<?php

namespace Tests\Feature\Users;

use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Regression tests for the accessory and license sections of the user-item
 * transfer page. The GET page used to load AccessoryCheckout and LicenseSeat
 * unconditionally after only asset-side authorization, so an asset-only
 * operator could read accessory and license names assigned to the source
 * user without accessories.view or licenses.view. The read-path gate on
 * each section is independent so an actor with the asset perms can still
 * use the page for its primary hardware-transfer purpose.
 */
class TransferUserItemsPageSectionGatingTest extends TestCase
{
    #[Test]
    public function asset_only_operator_sees_assets_but_not_accessory_or_license_names(): void
    {
        $source = User::factory()->create();
        Asset::factory()->create(['assigned_to' => $source->id, 'assigned_type' => User::class]);

        $accessory = Accessory::factory()->create(['name' => 'CAND04-ACCESSORY-SECRET']);
        AccessoryCheckout::factory()->create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $source->id,
            'assigned_type' => User::class,
        ]);

        $license = License::factory()->create(['name' => 'CAND04-LICENSE-SECRET', 'reassignable' => 1]);
        LicenseSeat::factory()
            ->assignedToUser($source)
            ->create(['license_id' => $license->id]);

        $actor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->create();

        $response = $this->actingAs($actor)
            ->get(route('users.transfer.show', $source))
            ->assertOk()
            ->assertViewIs('users.transfer');

        $response->assertDontSee('CAND04-ACCESSORY-SECRET');
        $response->assertDontSee('CAND04-LICENSE-SECRET');
    }

    #[Test]
    public function accessory_section_is_visible_when_actor_holds_accessories_view(): void
    {
        $source = User::factory()->create();

        $accessory = Accessory::factory()->create(['name' => 'CAND04-ACCESSORY-VISIBLE']);
        AccessoryCheckout::factory()->create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $source->id,
            'assigned_type' => User::class,
        ]);

        $actor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->viewAccessories()
            ->create();

        $this->actingAs($actor)
            ->get(route('users.transfer.show', $source))
            ->assertOk()
            ->assertSee('CAND04-ACCESSORY-VISIBLE');
    }

    #[Test]
    public function license_section_is_visible_when_actor_holds_licenses_view(): void
    {
        $source = User::factory()->create();

        $license = License::factory()->create(['name' => 'CAND04-LICENSE-VISIBLE', 'reassignable' => 1]);
        LicenseSeat::factory()
            ->assignedToUser($source)
            ->create(['license_id' => $license->id]);

        $actor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->viewLicenses()
            ->create();

        $this->actingAs($actor)
            ->get(route('users.transfer.show', $source))
            ->assertOk()
            ->assertSee('CAND04-LICENSE-VISIBLE');
    }

    #[Test]
    public function asset_only_operator_is_redirected_when_source_user_has_only_accessories_and_licenses(): void
    {
        $source = User::factory()->create();

        $accessory = Accessory::factory()->create();
        AccessoryCheckout::factory()->create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $source->id,
            'assigned_type' => User::class,
        ]);

        $license = License::factory()->create(['reassignable' => 1]);
        LicenseSeat::factory()
            ->assignedToUser($source)
            ->create(['license_id' => $license->id]);

        $actor = User::factory()
            ->viewUsers()
            ->checkinAssets()
            ->checkoutAssets()
            ->create();

        // With accessory + license sections gated off and no transferable
        // assets, the page has nothing to offer this actor and the controller
        // short-circuits back to the user profile.
        $this->actingAs($actor)
            ->get(route('users.transfer.show', $source))
            ->assertRedirect(route('users.show', $source));
    }
}
