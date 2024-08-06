<?php

namespace Tests\Feature\AssetModels\Api;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateAssetModelsTest extends TestCase
{


    public function testRequiresPermissionToCreateAssetModel()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.models.store'))
            ->assertForbidden();
    }

    public function testCanCreateAssetModelWithAssetModelType()
    {
        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.models.store'), [
                'name' => 'Test AssetModel',
                'category_id' => Category::factory()->create()->id
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $this->assertTrue(AssetModel::where('name', 'Test AssetModel')->exists());

        $model = AssetModel::find($response['payload']['id']);
        $this->assertEquals('Test AssetModel', $model->name);
    }

    public function testCannotCreateAssetModelWithoutCategory()
    {
        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.models.store'), [
                'name' => 'Test AssetModel',
            ])
            ->assertStatus(200)
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertJson([
                'messages' => [
                    'category_id'    => ['The category id field is required.'],
                ],
            ])
            ->json();

        // dd($response);
        $this->assertFalse(AssetModel::where('name', 'Test AssetModel')->exists());

    }

}
