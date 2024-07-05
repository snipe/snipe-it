<?php

namespace Tests\Feature\Categories\Api;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class UpdateCategoriesTest extends TestCase
{

    public function testCanUpdateCategoryViaPatchWithoutCategoryType()
    {
        $category = Category::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.categories.update', $category), [
                'name' => 'Test Category',
                'eula_text' => 'Test EULA',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        //dd($response);
        $category->refresh();
        $this->assertEquals('Test Category', $category->name, 'Name was not updated');
        $this->assertEquals('Test EULA', $category->eula_text, 'EULA was not updated');

    }

    public function testCannotUpdateCategoryViaPatchWithCategoryType()
    {
        $category = Category::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.categories.update', $category), [
                'name' => 'Test Category',
                'eula_text' => 'Test EULA',
                'category_type' => 'accessory',
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();
        
        $category->refresh();
        $this->assertNotEquals('Test Category', $category->name, 'Name was not updated');
        $this->assertNotEquals('Test EULA', $category->eula_text, 'EULA was not updated');
        $this->assertNotEquals('accessory', $category->category_type, 'EULA was not updated');

    }

}
