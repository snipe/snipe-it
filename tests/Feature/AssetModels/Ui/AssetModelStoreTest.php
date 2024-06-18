<?php

namespace Tests\Feature\AssetModels\Ui;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class AssetModelStoreTest extends TestCase
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
}
