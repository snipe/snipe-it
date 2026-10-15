<?php

namespace Tests\Feature\AssetModels\Ui;

use App\Models\Actionlog;
use App\Models\AssetModel;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for the double-logging bug on the web-side asset
 * model restore endpoint. Two separate sources were writing action_log
 * rows for a single restore:
 *
 *   - The controller wrote a manual `restore` log after $model->restore().
 *   - AssetModelObserver's `restoring` hook also wrote a `restore` log.
 *   - AssetModelObserver's `updating` hook fired via save() and wrote an
 *     `update` log showing `deleted_at` flipping from a timestamp to null.
 *
 * Three log rows per restore instead of one. The manual controller write
 * was removed, and the updating observer now filters `deleted_at` +
 * `updated_at` out of its diff so it no longer fires on restore. Tests
 * pin both behaviors down.
 */
class RestoreAssetModelTest extends TestCase
{
    public function test_permission_required_to_restore_asset_model(): void
    {
        $model = AssetModel::factory()->create();
        $model->delete();

        $this->actingAs(User::factory()->create())
            ->post(route('models.restore.store', $model->id))
            ->assertForbidden();
    }

    public function test_create_permission_alone_cannot_restore_asset_model(): void
    {
        // Regression: getRestore() used to authorize `create`, so a caller
        // holding models.create but not models.delete could reverse an
        // admin's soft-delete. Every sibling restore path in the project
        // (users, locations, manufacturers, assets, bulk assets, and this
        // model's API sibling Api\AssetModelsController::restore) authorizes
        // `delete` instead. Pinning the correct behavior here.
        $model = AssetModel::factory()->create();
        $model->delete();

        $this->actingAs(User::factory()->createAssetModels()->create())
            ->post(route('models.restore.store', $model->id))
            ->assertForbidden();

        $this->assertNotNull($model->fresh()->deleted_at, 'Restore should not have run.');
    }

    public function test_delete_permission_can_restore_asset_model(): void
    {
        // The paired positive case: models.delete IS the right permission
        // for restore, matching every sibling restore action.
        $model = AssetModel::factory()->create();
        $model->delete();

        $this->actingAs(User::factory()->deleteAssetModels()->create())
            ->post(route('models.restore.store', $model->id))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertNull($model->fresh()->deleted_at);
    }

    public function test_soft_deleted_asset_model_can_be_restored_via_web(): void
    {
        $model = AssetModel::factory()->create();
        $model->delete();
        $this->assertNotNull($model->fresh()->deleted_at);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.restore.store', $model->id))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertNull($model->fresh()->deleted_at);
    }

    public function test_restore_writes_exactly_one_restore_action_log(): void
    {
        $model = AssetModel::factory()->create();
        $model->delete();

        $before = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'restore')
            ->count();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.restore.store', $model->id))
            ->assertRedirect();

        $after = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'restore')
            ->count();

        $this->assertSame($before + 1, $after, 'Expected exactly one restore action_log entry (regression: was 2 pre-fix, one from the controller and one from the observer).');
    }

    public function test_restore_does_not_write_an_update_action_log(): void
    {
        $model = AssetModel::factory()->create();
        $model->delete();

        $before = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'update')
            ->count();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.restore.store', $model->id))
            ->assertRedirect();

        $after = Actionlog::where('item_type', AssetModel::class)
            ->where('item_id', $model->id)
            ->where('action_type', 'update')
            ->count();

        $this->assertSame($before, $after, 'Expected no update action_log entry on restore (regression: was 1 pre-fix, from the updating observer catching deleted_at flipping to null via save()).');
    }
}
