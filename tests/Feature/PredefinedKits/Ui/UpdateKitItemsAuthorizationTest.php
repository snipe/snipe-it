<?php

namespace Tests\Feature\PredefinedKits\Ui;

use App\Models\Accessory;
use App\Models\AssetModel;
use App\Models\Consumable;
use App\Models\License;
use App\Models\PredefinedKit;
use App\Models\User;
use Tests\TestCase;

/**
 * Web sibling of tests/Feature/PredefinedKits/Api/UpdateKitItemsTest.
 * FD-56594 added `findOrFail` + `authorize('view', $object)` to the four
 * update handlers on `Api\PredefinedKitsController`, but the parallel
 * handlers on the web `Kits\PredefinedKitsController` (`updateLicense`,
 * `updateModel`, `updateAccessory`, `updateConsumable`) were not covered
 * by that fix. A `kits.edit` holder could re-point an existing pivot at
 * an object id they cannot read directly, including one in another
 * company. This locks in the follow-up guards.
 */
class UpdateKitItemsAuthorizationTest extends TestCase
{
    // -------------------------------------------------------------------------
    // Licenses
    // -------------------------------------------------------------------------

    public function test_web_update_kit_license_requires_view_permission_on_target_license()
    {
        $kit = PredefinedKit::factory()->create();
        $existingLicense = License::factory()->create();
        $kit->licenses()->attach($existingLicense->id, ['quantity' => 1]);
        $pivotId = $kit->licenses()->wherePivot('license_id', $existingLicense->id)->first()->pivot->id;

        // Attacker points the pivot at a different license they cannot view.
        $targetLicense = License::factory()->create();

        $this->actingAs(User::factory()->editPredefinedKits()->create())
            ->put(route('kits.licenses.update', ['kit' => $kit->id, 'license_id' => $existingLicense->id]), [
                'pivot_id' => $pivotId,
                'license_id' => $targetLicense->id,
                'quantity' => 5,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_licenses', [
            'kit_id' => $kit->id,
            'license_id' => $targetLicense->id,
        ]);
        $this->assertDatabaseHas('kits_licenses', [
            'kit_id' => $kit->id,
            'license_id' => $existingLicense->id,
            'quantity' => 1,
        ]);
    }

    public function test_web_update_kit_license_succeeds_when_view_permission_granted()
    {
        $kit = PredefinedKit::factory()->create();
        $existingLicense = License::factory()->create();
        $kit->licenses()->attach($existingLicense->id, ['quantity' => 1]);
        $pivotId = $kit->licenses()->wherePivot('license_id', $existingLicense->id)->first()->pivot->id;

        $targetLicense = License::factory()->create();

        $this->actingAs(User::factory()->editPredefinedKits()->viewLicenses()->create())
            ->put(route('kits.licenses.update', ['kit' => $kit->id, 'license_id' => $existingLicense->id]), [
                'pivot_id' => $pivotId,
                'license_id' => $targetLicense->id,
                'quantity' => 5,
            ])
            ->assertRedirect(route('kits.edit', $kit->id));

        $this->assertDatabaseHas('kits_licenses', [
            'kit_id' => $kit->id,
            'license_id' => $targetLicense->id,
            'quantity' => 5,
        ]);
    }

    // -------------------------------------------------------------------------
    // Models
    // -------------------------------------------------------------------------

    public function test_web_update_kit_model_requires_view_permission_on_target_model()
    {
        $kit = PredefinedKit::factory()->create();
        $existingModel = AssetModel::factory()->create();
        $kit->models()->attach($existingModel->id, ['quantity' => 1]);
        $pivotId = $kit->models()->wherePivot('model_id', $existingModel->id)->first()->pivot->id;

        $targetModel = AssetModel::factory()->create();

        $this->actingAs(User::factory()->editPredefinedKits()->create())
            ->put(route('kits.models.update', ['kit' => $kit->id, 'model_id' => $existingModel->id]), [
                'pivot_id' => $pivotId,
                'model_id' => $targetModel->id,
                'quantity' => 5,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_models', [
            'kit_id' => $kit->id,
            'model_id' => $targetModel->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // Accessories
    // -------------------------------------------------------------------------

    public function test_web_update_kit_accessory_requires_view_permission_on_target_accessory()
    {
        $kit = PredefinedKit::factory()->create();
        $existingAccessory = Accessory::factory()->create();
        $kit->accessories()->attach($existingAccessory->id, ['quantity' => 1]);
        $pivotId = $kit->accessories()->wherePivot('accessory_id', $existingAccessory->id)->first()->pivot->id;

        $targetAccessory = Accessory::factory()->create();

        $this->actingAs(User::factory()->editPredefinedKits()->create())
            ->put(route('kits.accessories.update', ['kit' => $kit->id, 'accessory_id' => $existingAccessory->id]), [
                'pivot_id' => $pivotId,
                'accessory_id' => $targetAccessory->id,
                'quantity' => 5,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_accessories', [
            'kit_id' => $kit->id,
            'accessory_id' => $targetAccessory->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // Consumables
    // -------------------------------------------------------------------------

    public function test_web_update_kit_consumable_requires_view_permission_on_target_consumable()
    {
        $kit = PredefinedKit::factory()->create();
        $existingConsumable = Consumable::factory()->create();
        $kit->consumables()->attach($existingConsumable->id, ['quantity' => 1]);
        $pivotId = $kit->consumables()->wherePivot('consumable_id', $existingConsumable->id)->first()->pivot->id;

        $targetConsumable = Consumable::factory()->create();

        $this->actingAs(User::factory()->editPredefinedKits()->create())
            ->put(route('kits.consumables.update', ['kit' => $kit->id, 'consumable_id' => $existingConsumable->id]), [
                'pivot_id' => $pivotId,
                'consumable_id' => $targetConsumable->id,
                'quantity' => 5,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('kits_consumables', [
            'kit_id' => $kit->id,
            'consumable_id' => $targetConsumable->id,
        ]);
    }
}
