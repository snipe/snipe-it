<?php

namespace Tests\Feature\CheckoutAcceptances;

use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Regression tests for the CAND-09 race on acceptance finalization.
 *
 * CheckoutAcceptance::accept() and decline() used to do an unconditional
 * save() followed by the item-specific side effects (deleting an accessory
 * checkout, nulling an asset's assigned_to, etc). Two overlapping requests
 * could both load the acceptance while isPending() was true and both run
 * the side-effect chain. For accessory declines in particular,
 * Accessory::declinedCheckout picks the "latest" AccessoryCheckout row by
 * created_at with no acceptance binding, so the second stale request would
 * delete an older, legitimate assignment.
 *
 * The fix moves accept() and decline() to a compare-and-set UPDATE scoped
 * by whereNull on both timestamps. The first caller wins at the database
 * layer. The second caller's UPDATE affects zero rows, the method returns
 * false, and side effects do not run.
 */
class AcceptanceFinalizationRaceTest extends TestCase
{
    #[Test]
    public function second_decline_on_a_stale_acceptance_does_not_delete_an_unrelated_older_accessory_checkout(): void
    {
        $user = User::factory()->create();
        $accessory = Accessory::factory()->create();

        $older = AccessoryCheckout::factory()->create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $user->id,
            'assigned_type' => User::class,
            'created_at' => now()->subWeek(),
        ]);

        $newer = AccessoryCheckout::factory()->create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $user->id,
            'assigned_type' => User::class,
            'created_at' => now(),
        ]);

        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for($accessory, 'checkoutable')
            ->create([
                'assigned_to_id' => $user->id,
                'qty' => 1,
            ]);

        $firstInstance = CheckoutAcceptance::find($acceptance->id);
        $secondInstance = CheckoutAcceptance::find($acceptance->id);

        $this->assertTrue($firstInstance->isPending());
        $this->assertTrue($secondInstance->isPending());

        $this->assertTrue($firstInstance->decline(''));

        $this->assertFalse(
            $secondInstance->decline(''),
            'Second decline on a stale acceptance instance must return false, not run side effects.'
        );

        $this->assertNull(
            AccessoryCheckout::find($newer->id),
            'Winning decline should have removed the newer AccessoryCheckout (the one tied to this acceptance).'
        );
        $this->assertNotNull(
            AccessoryCheckout::find($older->id),
            'Older unrelated AccessoryCheckout must survive. Stale second decline must not delete it.'
        );
    }

    #[Test]
    public function second_accept_on_a_stale_acceptance_returns_false(): void
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for($asset, 'checkoutable')
            ->create(['assigned_to_id' => $user->id]);

        $firstInstance = CheckoutAcceptance::find($acceptance->id);
        $secondInstance = CheckoutAcceptance::find($acceptance->id);

        $this->assertTrue($firstInstance->accept('', null, null, 'first'));
        $this->assertFalse(
            $secondInstance->accept('', null, null, 'second'),
            'Second accept on a stale instance must return false.'
        );

        $this->assertSame(
            'first',
            CheckoutAcceptance::find($acceptance->id)->note,
            'Winning accept note must survive. Stale second accept must not overwrite it.'
        );
    }

    #[Test]
    public function decline_cannot_overwrite_a_previously_accepted_acceptance(): void
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for($asset, 'checkoutable')
            ->create(['assigned_to_id' => $user->id]);

        $acceptInstance = CheckoutAcceptance::find($acceptance->id);
        $declineInstance = CheckoutAcceptance::find($acceptance->id);

        $this->assertTrue($acceptInstance->accept(''));
        $this->assertFalse(
            $declineInstance->decline(''),
            'Decline must not succeed after accept has already finalized the row.'
        );

        $fresh = CheckoutAcceptance::find($acceptance->id);
        $this->assertNotNull($fresh->accepted_at);
        $this->assertNull($fresh->declined_at);
    }

    #[Test]
    public function decline_still_runs_qty_side_effects_on_the_winning_caller(): void
    {
        // qty > 1 case. The loop that used to live in the controller has
        // moved inside decline(), so the winning caller still deletes
        // $qty AccessoryCheckout rows.
        $user = User::factory()->create();
        $accessory = Accessory::factory()->create();

        AccessoryCheckout::factory()->count(3)->create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $user->id,
            'assigned_type' => User::class,
        ]);

        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for($accessory, 'checkoutable')
            ->create([
                'assigned_to_id' => $user->id,
                'qty' => 3,
            ]);

        $this->assertSame(3, AccessoryCheckout::where('assigned_to', $user->id)->count());

        $this->assertTrue($acceptance->decline(''));

        $this->assertSame(
            0,
            AccessoryCheckout::where('assigned_to', $user->id)->count(),
            'qty=3 decline should remove all 3 AccessoryCheckout rows.'
        );
    }
}
