<?php

namespace Tests\Feature\PredefinedKits\Api;

use App\Models\Accessory;
use App\Models\AssetModel;
use App\Models\Consumable;
use App\Models\License;
use App\Models\PredefinedKit;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression tests for the update-path / storeModel sibling of the store-side
 * authorization bypass covered by AttachKitItemsTest. The original fix for
 * CVE-2026-55478 added findOrFail + authorize('view', $object) to the three
 * store methods but left the parallel update methods (updateLicense,
 * updateConsumable, updateAccessory, updateModel) and storeModel without the
 * object-level view check. This test file locks in the follow-up fix that
 * mirrors the store-method pattern in those five methods.
 *
 * Each resource has three tests:
 *   - kit-edit permission required (without it, 403)
 *   - view permission on the object required (without it, 403)
 *   - both permissions together succeed (200)
 */
class UpdateKitItemsTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Licenses (update)
    // -------------------------------------------------------------------------

    public function test_updating_kit_license_requires_kit_edit_permission()
    {
        $kit = PredefinedKit::factory()->create();
        $license = License::factory()->create();
        $kit->licenses()->attach($license->id, ['quantity' => 1]);

        $this->actingAsForApi(User::factory()->viewLicenses()->create())
            ->putJson(route('api.kits.licenses.update', ['kit_id' => $kit->id, 'license_id' => $license->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseHas('kits_licenses', ['kit_id' => $kit->id, 'license_id' => $license->id, 'quantity' => 1]);
    }

    public function test_updating_kit_license_requires_view_permission_on_license()
    {
        $kit = PredefinedKit::factory()->create();
        $license = License::factory()->create();

        // The bypass: kits.edit alone previously let a user attach (and leak)
        // a license they could not read directly.
        $this->actingAsForApi(User::factory()->editPredefinedKits()->create())
            ->putJson(route('api.kits.licenses.update', ['kit_id' => $kit->id, 'license_id' => $license->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_licenses', ['kit_id' => $kit->id, 'license_id' => $license->id]);
    }

    public function test_can_update_kit_license_with_both_permissions()
    {
        $kit = PredefinedKit::factory()->create();
        $license = License::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->viewLicenses()->create())
            ->putJson(route('api.kits.licenses.update', ['kit_id' => $kit->id, 'license_id' => $license->id]), ['quantity' => 5])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('kits_licenses', ['kit_id' => $kit->id, 'license_id' => $license->id, 'quantity' => 5]);
    }

    // -------------------------------------------------------------------------
    // Consumables (update)
    // -------------------------------------------------------------------------

    public function test_updating_kit_consumable_requires_kit_edit_permission()
    {
        $kit = PredefinedKit::factory()->create();
        $consumable = Consumable::factory()->create();
        $kit->consumables()->attach($consumable->id, ['quantity' => 1]);

        $this->actingAsForApi(User::factory()->viewConsumables()->create())
            ->putJson(route('api.kits.consumables.update', ['kit_id' => $kit->id, 'consumable_id' => $consumable->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseHas('kits_consumables', ['kit_id' => $kit->id, 'consumable_id' => $consumable->id, 'quantity' => 1]);
    }

    public function test_updating_kit_consumable_requires_view_permission_on_consumable()
    {
        $kit = PredefinedKit::factory()->create();
        $consumable = Consumable::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->create())
            ->putJson(route('api.kits.consumables.update', ['kit_id' => $kit->id, 'consumable_id' => $consumable->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_consumables', ['kit_id' => $kit->id, 'consumable_id' => $consumable->id]);
    }

    public function test_can_update_kit_consumable_with_both_permissions()
    {
        $kit = PredefinedKit::factory()->create();
        $consumable = Consumable::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->viewConsumables()->create())
            ->putJson(route('api.kits.consumables.update', ['kit_id' => $kit->id, 'consumable_id' => $consumable->id]), ['quantity' => 5])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('kits_consumables', ['kit_id' => $kit->id, 'consumable_id' => $consumable->id, 'quantity' => 5]);
    }

    // -------------------------------------------------------------------------
    // Accessories (update)
    // -------------------------------------------------------------------------

    public function test_updating_kit_accessory_requires_kit_edit_permission()
    {
        $kit = PredefinedKit::factory()->create();
        $accessory = Accessory::factory()->create();
        $kit->accessories()->attach($accessory->id, ['quantity' => 1]);

        $this->actingAsForApi(User::factory()->viewAccessories()->create())
            ->putJson(route('api.kits.accessories.update', ['kit_id' => $kit->id, 'accessory_id' => $accessory->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseHas('kits_accessories', ['kit_id' => $kit->id, 'accessory_id' => $accessory->id, 'quantity' => 1]);
    }

    public function test_updating_kit_accessory_requires_view_permission_on_accessory()
    {
        $kit = PredefinedKit::factory()->create();
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->create())
            ->putJson(route('api.kits.accessories.update', ['kit_id' => $kit->id, 'accessory_id' => $accessory->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_accessories', ['kit_id' => $kit->id, 'accessory_id' => $accessory->id]);
    }

    public function test_can_update_kit_accessory_with_both_permissions()
    {
        $kit = PredefinedKit::factory()->create();
        $accessory = Accessory::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->viewAccessories()->create())
            ->putJson(route('api.kits.accessories.update', ['kit_id' => $kit->id, 'accessory_id' => $accessory->id]), ['quantity' => 5])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('kits_accessories', ['kit_id' => $kit->id, 'accessory_id' => $accessory->id, 'quantity' => 5]);
    }

    // -------------------------------------------------------------------------
    // Models (attach + update)
    // -------------------------------------------------------------------------

    public function test_attaching_kit_model_requires_kit_edit_permission()
    {
        $kit = PredefinedKit::factory()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->viewAssetModels()->create())
            ->postJson(route('api.kits.models.store', $kit), ['model' => $model->id, 'quantity' => 1])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_models', ['kit_id' => $kit->id, 'model_id' => $model->id]);
    }

    public function test_attaching_kit_model_requires_view_permission_on_model()
    {
        $kit = PredefinedKit::factory()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->create())
            ->postJson(route('api.kits.models.store', $kit), ['model' => $model->id, 'quantity' => 1])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_models', ['kit_id' => $kit->id, 'model_id' => $model->id]);
    }

    public function test_can_attach_kit_model_with_both_permissions()
    {
        $kit = PredefinedKit::factory()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->viewAssetModels()->create())
            ->postJson(route('api.kits.models.store', $kit), ['model' => $model->id, 'quantity' => 1])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('kits_models', ['kit_id' => $kit->id, 'model_id' => $model->id]);
    }

    public function test_updating_kit_model_requires_kit_edit_permission()
    {
        $kit = PredefinedKit::factory()->create();
        $model = AssetModel::factory()->create();
        $kit->models()->attach($model->id, ['quantity' => 1]);

        $this->actingAsForApi(User::factory()->viewAssetModels()->create())
            ->putJson(route('api.kits.models.update', ['kit_id' => $kit->id, 'model_id' => $model->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseHas('kits_models', ['kit_id' => $kit->id, 'model_id' => $model->id, 'quantity' => 1]);
    }

    public function test_updating_kit_model_requires_view_permission_on_model()
    {
        $kit = PredefinedKit::factory()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->create())
            ->putJson(route('api.kits.models.update', ['kit_id' => $kit->id, 'model_id' => $model->id]), ['quantity' => 5])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_models', ['kit_id' => $kit->id, 'model_id' => $model->id]);
    }

    public function test_can_update_kit_model_with_both_permissions()
    {
        $kit = PredefinedKit::factory()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->editPredefinedKits()->viewAssetModels()->create())
            ->putJson(route('api.kits.models.update', ['kit_id' => $kit->id, 'model_id' => $model->id]), ['quantity' => 5])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('kits_models', ['kit_id' => $kit->id, 'model_id' => $model->id, 'quantity' => 5]);
    }
}
