<?php

namespace Tests\Feature\AssetModels\Api;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\User;
use Tests\TestCase;

/**
 * Verifies the per-row eligibility flags that drive the models index bulk-actions
 * dropdown. `available_actions.bulk_selectable.edit` gates the bulk-edit action;
 * `available_actions.bulk_selectable.delete` gates the bulk-delete action. The
 * dropdown intersects these keys across all selected rows.
 */
class BulkSelectableTest extends TestCase
{
    public function test_clean_model_supports_both_edit_and_delete()
    {
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.show', $model))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', true);
    }

    public function test_soft_deleted_model_supports_neither()
    {
        // api.models.show excludes soft-deleted rows, so we assert via the
        // index endpoint with status=deleted which does return them.
        $model = AssetModel::factory()->create(['name' => 'unique-'.uniqid()]);
        $model->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.index', ['status' => 'deleted', 'search' => $model->name]))
            ->assertOk()
            ->assertJsonPath('rows.0.id', $model->id)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.edit', false)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.delete', false);
    }

    public function test_model_with_assigned_assets_cannot_be_deleted()
    {
        $model = AssetModel::factory()->create();
        Asset::factory()->create(['model_id' => $model->id]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.models.show', $model))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', false);
    }

    public function test_user_without_edit_permission_gets_edit_false()
    {
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->viewAssetModels()->deleteAssetModels()->create())
            ->getJson(route('api.models.show', $model))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', false)
            ->assertJsonPath('available_actions.bulk_selectable.delete', true);
    }

    public function test_user_without_delete_permission_gets_delete_false()
    {
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->viewAssetModels()->editAssetModels()->create())
            ->getJson(route('api.models.show', $model))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', false);
    }
}
