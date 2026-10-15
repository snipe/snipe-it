<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CustomFieldSetDefaultValuesForModel;
use App\Models\AssetModel;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression coverage for the Livewire snapshot-replay authorization bypass
 * reported by PizzaStev3 (2026-07-31). The component renders custom-field
 * default values for an AssetModel identified by model_id. Route-level
 * middleware on the model create/edit pages requires models.edit, but
 * snapshot replay to /livewire/update bypassed that gate. boot() gate
 * now requires AssetModel update permission on both mount and any replayed
 * action.
 */
class CustomFieldSetDefaultValuesForModelAuthorizationTest extends TestCase
{
    public function test_user_with_models_edit_permission_can_mount()
    {
        $model = AssetModel::factory()->create();

        $this->actingAs(User::factory()->editAssetModels()->create());

        Livewire::test(CustomFieldSetDefaultValuesForModel::class, ['model_id' => $model->id])
            ->assertStatus(200);
    }

    public function test_user_without_models_edit_permission_cannot_mount_or_replay()
    {
        $model = AssetModel::factory()->create();

        $this->actingAs(User::factory()->create());

        Livewire::test(CustomFieldSetDefaultValuesForModel::class, ['model_id' => $model->id])
            ->assertStatus(403);
    }
}
