<?php

namespace Tests\Feature\AssetModels\Api;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class DeleteAssetModelsTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $assetModel = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.models.destroy', $assetModel))
            ->assertForbidden();
    }

    public function testCanDeleteAssetModel()
    {
        $assetModel = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->deleteAssetModels()->create())
            ->deleteJson(route('api.models.destroy', $assetModel))
            ->assertStatusMessageIs('success');

        $this->assertTrue($assetModel->fresh()->trashed());
    }

    public function testCannotDeleteAssetModelThatStillHasAssociatedAssets()
    {
        $assetModel = Asset::factory()->create()->model;

        $this->actingAsForApi(User::factory()->deleteAssetModels()->create())
            ->deleteJson(route('api.models.destroy', $assetModel))
            ->assertStatusMessageIs('error');

        $this->assertFalse($assetModel->fresh()->trashed());
    }
}
