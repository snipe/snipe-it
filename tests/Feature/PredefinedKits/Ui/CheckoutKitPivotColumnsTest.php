<?php

namespace Tests\Feature\PredefinedKits\Ui;

use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\PredefinedKit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Regression coverage for issue #19818.
 *
 * The pivot inserts in PredefinedKitCheckoutService::saveToDb() wrote
 * a `user_id` column that no longer exists on either consumables_users
 * or accessories_checkout (renamed to `created_by`). Checkout of any
 * kit containing a consumable or accessory 500ed with an "Unknown
 * column 'user_id'" error.
 *
 * The accessory path also tripped a MariaDB 1066 "Not unique
 * table/alias" error in getAccessoriesToAdd before even reaching the
 * save step, because $kit->accessories()->with('users') eager-loaded
 * a belongsToMany relation whose pivot and destination tables are
 * both accessories_checkout.
 */
class CheckoutKitPivotColumnsTest extends TestCase
{
    public function test_kit_containing_a_consumable_checks_out_successfully()
    {
        // The service calls authorize('checkout', Asset::class) in the
        // controller and authorize('checkout', $consumable) in the
        // service, so the actor needs the narrow intersection of asset
        // and consumable checkout rights. Using superuser here would
        // mask policy nuances a non-superuser installation might trip.
        $actor = User::factory()->checkoutAssets()->checkoutConsumables()->create();
        $target = User::factory()->create();

        $consumable = Consumable::factory()->create(['qty' => 5]);

        $kit = PredefinedKit::factory()->create();
        $kit->consumables()->attach($consumable->id, ['quantity' => 1]);

        $this->actingAs($actor)
            ->post(route('kits.checkout.store', $kit), ['user_id' => $target->id])
            ->assertSessionHas('success');

        $pivot = DB::table('consumables_users')
            ->where('consumable_id', $consumable->id)
            ->where('assigned_to', $target->id)
            ->first();

        $this->assertNotNull($pivot, 'A consumables_users row must be written for the target user.');
        $this->assertSame(
            $actor->id,
            (int) $pivot->created_by,
            'created_by must hold the acting admin id. The legacy user_id key is gone.',
        );
    }

    public function test_kit_containing_an_accessory_checks_out_successfully()
    {
        $actor = User::factory()->checkoutAssets()->checkoutAccessories()->create();
        $target = User::factory()->create();

        $accessory = Accessory::factory()->create(['qty' => 5]);

        $kit = PredefinedKit::factory()->create();
        $kit->accessories()->attach($accessory->id, ['quantity' => 1]);

        $this->actingAs($actor)
            ->post(route('kits.checkout.store', $kit), ['user_id' => $target->id])
            ->assertSessionHas('success');

        $pivot = DB::table('accessories_checkout')
            ->where('accessory_id', $accessory->id)
            ->where('assigned_to', $target->id)
            ->first();

        $this->assertNotNull($pivot, 'An accessories_checkout row must be written for the target user.');
        $this->assertSame(
            $actor->id,
            (int) $pivot->created_by,
            'created_by must hold the acting admin id. The legacy user_id key is gone.',
        );
        $this->assertSame(
            User::class,
            $pivot->assigned_type,
            'assigned_type must be set on the pivot so the polymorphic assignedTo relation resolves.',
        );
    }
}
