<?php

namespace Tests\Feature\AssetModels\Api;

use App\Models\Actionlog;
use App\Models\AssetModel;
use App\Models\User;
use Tests\TestCase;

class RestoreAssetModelTest extends TestCase
{
    public function test_permission_required_to_restore_asset_model(): void
    {
        $model = AssetModel::factory()->create();
        $model->delete();

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.models.restore', $model->id))
            ->assertStatus(403);
    }

    public function test_error_returned_if_asset_model_does_not_exist(): void
    {
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.models.restore', 999999))
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function test_error_returned_if_asset_model_is_not_deleted(): void
    {
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.models.restore', $model->id))
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function test_soft_deleted_asset_model_can_be_restored(): void
    {
        $model = AssetModel::factory()->create();
        $model->delete();
        $this->assertNotNull($model->fresh()->deleted_at);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.models.restore', $model->id))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertNull($model->fresh()->deleted_at);
    }

    public function test_restore_writes_action_log_entry(): void
    {
        $model = AssetModel::factory()->create();
        $model->delete();

        $before = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'restore')
            ->count();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.models.restore', $model->id))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $after = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'restore')
            ->count();

        $this->assertSame($before + 1, $after, 'Expected one restore action_log entry to be written.');
    }

    public function test_restore_does_not_write_an_update_action_log(): void
    {
        // AssetModelObserver::updating fires during restore because
        // Laravel's restore() calls save(). Pre-fix that observer
        // logged an "update" entry showing `deleted_at` flipping to
        // null. AssetModelObserver now filters deleted_at + updated_at
        // out of the diff so no bogus update entry gets written on
        // restore. See the matching test in the web-side
        // RestoreAssetModelTest.
        $model = AssetModel::factory()->create();
        $model->delete();

        $before = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'update')
            ->count();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.models.restore', $model->id))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $after = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'update')
            ->count();

        $this->assertSame($before, $after, 'Expected no update action_log entry on restore.');
    }
}
