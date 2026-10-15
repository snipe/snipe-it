<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Regression coverage for the concurrent-checkout race reported on
 * 2026-08-02. Assets\AssetCheckoutController::store() checked
 * availableForCheckout outside its checkOut() call, with no lock and no
 * re-check. Two racing form submits could both see the asset as available,
 * both invoke checkOut(), and land duplicate checkout-history rows plus a
 * doubled checkout_counter.
 *
 * The fix wraps checkOut() in a DB::transaction that begins with a
 * lockForUpdate re-fetch + re-check, mirroring the API fix and the
 * ConsumablesController pattern from GHSA-x4g2-87xc-m5jm. This test cannot
 * simulate two truly concurrent form submits in phpunit, but it pins the
 * behavioral consequence: an asset that has already been assigned
 * mid-flight cannot be checked out a second time.
 */
class AssetCheckoutRaceGuardTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake([CheckoutableCheckedOut::class]);
    }

    public function test_second_checkout_of_already_assigned_asset_does_not_increment_counter()
    {
        $firstTarget = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($firstTarget)->create(['checkout_counter' => 1]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('hardware.checkout.store', $asset), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
            ])
            ->assertRedirect();

        $asset->refresh();
        $this->assertSame(1, (int) $asset->checkout_counter, 'checkout_counter must not increment when checkout is refused');
        $this->assertSame($firstTarget->id, (int) $asset->assigned_to, 'existing assignment must remain intact');
    }

    public function test_second_checkout_of_already_assigned_asset_does_not_fire_checkout_event()
    {
        $firstTarget = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($firstTarget)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('hardware.checkout.store', $asset), [
                'checkout_to_type' => 'user',
                'assigned_user' => User::factory()->create()->id,
            ])
            ->assertRedirect();

        Event::assertNotDispatched(CheckoutableCheckedOut::class);
    }
}
