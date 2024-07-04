<?php

namespace Tests\Feature\AssetModels\Ui;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class UpdateAssetModelsTest extends TestCase
{
    public function testPermissionRequiredToStoreAssetModel()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('models.store'), [
                'name' => 'Test Model',
                'category_id' => Category::factory()->create()->id
            ])
            ->assertForbidden();
    }

    public function testUserCanCreateAssetModels()
    {
        $this->assertFalse(AssetModel::where('name', 'Test Model')->exists());

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('models.store'), [
                'name' => 'Test Model',
                'category_id' => Category::factory()->create()->id
            ])
            ->assertRedirect(route('models.index'));

        $this->assertTrue(AssetModel::where('name', 'Test Model')->exists());
    }

    public function testUserCanEditAssetModels()
    {
        $model = AssetModel::factory()->create(['name' => 'Test Model', 'category_id' => Category::factory()->create()->id]);
        $this->assertTrue(AssetModel::where('name', 'Test Model')->exists());

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('models.update', ['model' => $model]), [
                'name' => 'Test Model Edited',
                'category_id' => $model->category_id,
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('models.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertTrue(AssetModel::where('name', 'Test Model Edited')->exists());

    }

    public function testUserCannotChangeAssetModelCategoryType()
    {
        $model = AssetModel::factory()->create(['name' => 'Test Model', 'category_id' => Category::factory()->forAssets()->create()->id]);
        $this->assertTrue(AssetModel::where('name', 'Test Model')->exists());

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('models.update', ['model' => $model]), [
                'name' => 'Test Model Edited',
                'category_id' => Category::factory()->forAccessories()->create()->id,
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('models.index'));

        $this->followRedirects($response)->assertSee(trans('general.error'));
        $this->assertFalse(AssetModel::where('name', 'Test Model Edited')->exists());

    }
}
