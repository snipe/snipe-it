<?php

namespace Tests\Feature\AssetModels\Api;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class UpdateAssetModelsTest extends TestCase
{

    public function testRequiresPermissionToEditAssetModel(): void
    {
        $model = AssetModel::factory()->create();
        $this->actingAsForApi(User::factory()->create())
            ->patchJson(route('api.models.update', $model))
            ->assertForbidden();
    }

    public function testCanUpdateAssetModelViaPatch(): void
    {
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.models.update', $model), [
                'name' => 'Test Model',
                'category_id' => Category::factory()->forAssets()->create()->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $model->refresh();
        $this->assertEquals('Test Model', $model->name, 'Name was not updated');

    }

    public function testCannotUpdateAssetModelViaPatchWithAccessoryCategory(): void
    {
        $category = Category::factory()->forAccessories()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.models.update', $model), [
                'name' => 'Test Model',
                'category_id' => $category->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();

        $category->refresh();
        $this->assertNotEquals('Test Model', $model->name, 'Name was not updated');
        $this->assertNotEquals('category_id', $category->id, 'Category ID was not updated');
    }

    public function testCannotUpdateAssetModelViaPatchWithLicenseCategory(): void
    {
        $category = Category::factory()->forLicenses()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.models.update', $model), [
                'name' => 'Test Model',
                'category_id' => $category->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();

        $category->refresh();
        $this->assertNotEquals('Test Model', $model->name, 'Name was not updated');
        $this->assertNotEquals('category_id', $category->id, 'Category ID was not updated');
    }

    public function testCannotUpdateAssetModelViaPatchWithConsumableCategory(): void
    {
        $category = Category::factory()->forConsumables()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.models.update', $model), [
                'name' => 'Test Model',
                'category_id' => $category->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();

        $category->refresh();
        $this->assertNotEquals('Test Model', $model->name, 'Name was not updated');
        $this->assertNotEquals('category_id', $category->id, 'Category ID was not updated');
    }

    public function testCannotUpdateAssetModelViaPatchWithComponentCategory(): void
    {
        $category = Category::factory()->forComponents()->create();
        $model = AssetModel::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.models.update', $model), [
                'name' => 'Test Model',
                'category_id' => $category->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();

        $category->refresh();
        $this->assertNotEquals('Test Model', $model->name, 'Name was not updated');
        $this->assertNotEquals('category_id', $category->id, 'Category ID was not updated');
    }

}
