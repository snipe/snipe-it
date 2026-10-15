<?php

namespace Tests\Feature\AssetModels\Ui;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\User;
use Tests\TestCase;

class BulkMergeAssetModelsTest extends TestCase
{
    public function test_shows_confirmation_when_at_least_two_models_are_selected()
    {
        $modelA = AssetModel::factory()->create();
        $modelB = AssetModel::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.bulkedit.index'), [
                'ids' => [$modelA->id, $modelB->id],
                'bulk_actions' => 'merge',
            ])
            ->assertStatus(200)
            ->assertSee($modelA->name)
            ->assertSee($modelB->name);
    }

    public function test_redirects_to_index_when_fewer_than_two_models_selected()
    {
        // Merge requires at least two models. Selecting one is not
        // enough. Redirect with a flash instead of rendering the
        // confirmation view.
        $modelA = AssetModel::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('models.index'))
            ->post(route('models.bulkedit.index'), [
                'ids' => [$modelA->id],
                'bulk_actions' => 'merge',
            ])
            ->assertRedirect(route('models.index'))
            ->assertSessionHas('error');
    }

    public function test_merges_assets_from_source_models_into_target()
    {
        $target = AssetModel::factory()->create();
        $sourceA = AssetModel::factory()->create();
        $sourceB = AssetModel::factory()->create();

        $assetOnA = Asset::factory()->for($sourceA, 'model')->create();
        $assetOnB1 = Asset::factory()->for($sourceB, 'model')->create();
        $assetOnB2 = Asset::factory()->for($sourceB, 'model')->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.merge.save'), [
                'merge_into_id' => $target->id,
                'ids_to_merge' => [$target->id, $sourceA->id, $sourceB->id],
            ])
            ->assertRedirect(route('models.index'))
            ->assertSessionHas('success');

        // Every source model's assets now point at the target.
        $this->assertSame($target->id, $assetOnA->refresh()->model_id);
        $this->assertSame($target->id, $assetOnB1->refresh()->model_id);
        $this->assertSame($target->id, $assetOnB2->refresh()->model_id);

        // Source models are soft-deleted, target survives.
        $this->assertNull(AssetModel::find($sourceA->id));
        $this->assertNull(AssetModel::find($sourceB->id));
        $this->assertNotNull(AssetModel::find($target->id));
    }

    public function test_merge_target_is_not_deleted_even_when_listed_in_ids_to_merge()
    {
        // ids_to_merge carries the full selection including the target
        // (that's how the confirmation form posts). The controller must
        // exclude the target from the sources list before deleting so
        // it doesn't wipe the model we're merging into.
        $target = AssetModel::factory()->create();
        $source = AssetModel::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.merge.save'), [
                'merge_into_id' => $target->id,
                'ids_to_merge' => [$target->id, $source->id],
            ])
            ->assertRedirect(route('models.index'));

        $this->assertNotNull(AssetModel::find($target->id));
        $this->assertNull(AssetModel::find($source->id));
    }

    public function test_redirects_with_error_when_target_not_picked()
    {
        $source = AssetModel::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('models.index'))
            ->post(route('models.merge.save'), [
                'merge_into_id' => null,
                'ids_to_merge' => [$source->id],
            ])
            ->assertRedirect(route('models.index'))
            ->assertSessionHas('error');

        // Source is untouched.
        $this->assertNotNull(AssetModel::find($source->id));
    }

    public function test_merge_logs_actionlog_entries_on_both_source_and_target()
    {
        // Same shape as the user-merge log: one action_log entry per
        // source pointing at target, plus one entry per pair pointing
        // at target->source. So merging N sources into one target
        // yields 2N action_log rows, all with action_type 'merged'.
        $target = AssetModel::factory()->create();
        $sourceA = AssetModel::factory()->create();
        $sourceB = AssetModel::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.merge.save'), [
                'merge_into_id' => $target->id,
                'ids_to_merge' => [$target->id, $sourceA->id, $sourceB->id],
            ]);

        // Entry on each source model.
        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'merged',
            'item_id' => $sourceA->id,
            'item_type' => AssetModel::class,
            'target_id' => $target->id,
            'target_type' => AssetModel::class,
        ]);
        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'merged',
            'item_id' => $sourceB->id,
            'item_type' => AssetModel::class,
            'target_id' => $target->id,
            'target_type' => AssetModel::class,
        ]);

        // Entry on the target pointing at each source.
        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'merged',
            'item_id' => $target->id,
            'item_type' => AssetModel::class,
            'target_id' => $sourceA->id,
            'target_type' => AssetModel::class,
        ]);
        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'merged',
            'item_id' => $target->id,
            'item_type' => AssetModel::class,
            'target_id' => $sourceB->id,
            'target_type' => AssetModel::class,
        ]);
    }

    public function test_non_superusers_without_delete_permission_are_blocked()
    {
        $target = AssetModel::factory()->create();
        $source = AssetModel::factory()->create();

        // A user with no permissions at all shouldn't reach the merge
        // controller. The delete permission on AssetModel is what
        // gates it (matches the user-merge shape).
        $this->actingAs(User::factory()->create())
            ->post(route('models.merge.save'), [
                'merge_into_id' => $target->id,
                'ids_to_merge' => [$target->id, $source->id],
            ])
            ->assertForbidden();

        $this->assertNotNull(AssetModel::find($source->id));
    }
}
