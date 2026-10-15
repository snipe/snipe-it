<?php

namespace Tests\Feature\AssetModels\Ui;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\User;
use Tests\TestCase;

class BulkDeleteAssetModelsTest extends TestCase
{
    public function test_shows_confirmation_when_at_least_one_model_is_deletable()
    {
        // One model has assets attached (not deletable), one is clean.
        $modelWithAssets = AssetModel::factory()->create();
        Asset::factory()->for($modelWithAssets, 'model')->create();
        $cleanModel = AssetModel::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.bulkedit.index'), [
                'ids' => [$modelWithAssets->id, $cleanModel->id],
                'bulk_actions' => 'delete',
            ])
            ->assertStatus(200)
            ->assertSee($modelWithAssets->name)
            ->assertSee($cleanModel->name);
    }

    public function test_redirects_to_index_with_error_when_no_selected_models_are_deletable()
    {
        // Both models have assets attached, so neither is deletable.
        $modelA = AssetModel::factory()->create();
        Asset::factory()->for($modelA, 'model')->create();
        $modelB = AssetModel::factory()->create();
        Asset::factory()->for($modelB, 'model')->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('models.index'))
            ->post(route('models.bulkedit.index'), [
                'ids' => [$modelA->id, $modelB->id],
                'bulk_actions' => 'delete',
            ])
            ->assertRedirect(route('models.index'))
            ->assertSessionHas('error');
    }

    public function test_redirects_to_index_when_no_models_selected()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('models.index'))
            ->post(route('models.bulkedit.index'), [
                'ids' => null,
                'bulk_actions' => 'delete',
            ])
            ->assertRedirect(route('models.index'))
            ->assertSessionHas('error');
    }
}
