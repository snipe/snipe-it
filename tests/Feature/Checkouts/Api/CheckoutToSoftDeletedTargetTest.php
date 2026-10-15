<?php

namespace Tests\Feature\Checkouts\Api;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression tests confirming the API checkout endpoints refuse to bind
 * live inventory to soft-deleted targets. The vulnerable resolution used
 * Model::withoutGlobalScopes()->find(...) (added deliberately for FMCS
 * error messaging) without a post-lookup deleted_at guard, so trashed
 * users, assets, and locations were accepted as checkout destinations.
 *
 * Fix covers three layers:
 *   1. exists_undeleted validator on the AssetCheckoutRequest and
 *      AccessoryCheckoutRequest (422 bounce at request time).
 *   2. Post-withoutGlobalScopes deleted_at check in each of the four API
 *      checkout controllers.
 *   3. This regression suite locks in "trashed target => rejected" for
 *      every affected endpoint.
 */
class CheckoutToSoftDeletedTargetTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Asset checkout
    // -------------------------------------------------------------------------

    public function test_asset_checkout_rejects_soft_deleted_user_target()
    {
        $asset = Asset::factory()->create();
        $targetUser = User::factory()->create();
        $targetUser->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.asset.checkout', $asset), [
                'checkout_to_type' => 'user',
                'assigned_user' => $targetUser->id,
            ])
            ->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('assets', [
            'id' => $asset->id,
            'assigned_to' => $targetUser->id,
        ]);
    }

    public function test_asset_checkout_rejects_soft_deleted_asset_target()
    {
        $asset = Asset::factory()->create();
        $targetAsset = Asset::factory()->create();
        $targetAsset->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.asset.checkout', $asset), [
                'checkout_to_type' => 'asset',
                'assigned_asset' => $targetAsset->id,
            ])
            ->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('assets', [
            'id' => $asset->id,
            'assigned_to' => $targetAsset->id,
            'assigned_type' => Asset::class,
        ]);
    }

    public function test_asset_checkout_rejects_soft_deleted_location_target()
    {
        // Reporter flagged this case as "unverified due to FMCS mismatch" but
        // the code path is identical to the other two, so the fix must cover it.
        $asset = Asset::factory()->create();
        $targetLocation = Location::factory()->create();
        $targetLocation->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.asset.checkout', $asset), [
                'checkout_to_type' => 'location',
                'assigned_location' => $targetLocation->id,
            ])
            ->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('assets', [
            'id' => $asset->id,
            'assigned_to' => $targetLocation->id,
            'assigned_type' => Location::class,
        ]);
    }

    // -------------------------------------------------------------------------
    // Consumable checkout
    // -------------------------------------------------------------------------

    public function test_consumable_checkout_rejects_soft_deleted_user_target()
    {
        $consumable = Consumable::factory()->create();
        $target = User::factory()->create();
        $target->delete();

        $this->actingAsForApi(User::factory()->checkoutConsumables()->create())
            ->postJson(route('api.consumables.checkout', $consumable), [
                'assigned_to' => $target->id,
                'checkout_qty' => 1,
            ])
            ->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('consumables_users', [
            'consumable_id' => $consumable->id,
            'assigned_to' => $target->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // Component checkout
    // -------------------------------------------------------------------------

    public function test_component_checkout_rejects_soft_deleted_asset_target()
    {
        $component = Component::factory()->create();
        $target = Asset::factory()->create();
        $target->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.components.checkout', $component->id), [
                'assigned_to' => $target->id,
                'assigned_qty' => 1,
            ])
            ->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('components_assets', [
            'component_id' => $component->id,
            'asset_id' => $target->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // Accessory checkout (defense-in-depth: not vulnerable to this class of
    // bug because the accessory API uses the CheckInOutTrait's findOrFail
    // path which respects the SoftDeletes scope, but the exists_undeleted
    // rule on AccessoryCheckoutRequest catches the trashed target at request
    // validation time regardless).
    // -------------------------------------------------------------------------

    public function test_accessory_checkout_rejects_soft_deleted_user_target()
    {
        $accessory = Accessory::factory()->create();
        $target = User::factory()->create();
        $target->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $target->id,
                'checkout_to_type' => 'user',
                'checkout_qty' => 1,
            ])
            ->assertStatusMessageIs('error');

        $this->assertDatabaseMissing('accessories_checkout', [
            'accessory_id' => $accessory->id,
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
        ]);
    }

    // -------------------------------------------------------------------------
    // Happy paths (make sure the fix doesn't over-block)
    // -------------------------------------------------------------------------

    public function test_asset_checkout_still_works_with_live_user_target()
    {
        $asset = Asset::factory()->create();
        $target = User::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.asset.checkout', $asset), [
                'checkout_to_type' => 'user',
                'assigned_user' => $target->id,
            ])
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
        ]);
    }

    public function test_consumable_checkout_still_works_with_live_user_target()
    {
        $consumable = Consumable::factory()->create();
        $target = User::factory()->create();

        $this->actingAsForApi(User::factory()->checkoutConsumables()->create())
            ->postJson(route('api.consumables.checkout', $consumable), [
                'assigned_to' => $target->id,
                'checkout_qty' => 1,
            ])
            ->assertStatusMessageIs('success');
    }
}
