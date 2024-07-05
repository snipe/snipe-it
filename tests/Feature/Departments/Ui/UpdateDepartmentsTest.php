<?php

namespace Tests\Feature\Departments\Ui;

use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class UpdateDepartmentsTest extends TestCase
{
    public function testPermissionRequiredToStoreDepartment()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('departments.store'), [
                'name' => 'Test Department',
                'category_id' => Category::factory()->create()->id
            ])
            ->assertStatus(403)
            ->assertForbidden();
    }

    public function testUserCanCreateDepartments()
    {
        $this->assertFalse(Department::where('name', 'Test Department')->exists());

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('departments.store'), [
                'name' => 'Test Department',
                'category_id' => Category::factory()->create()->id
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('departments.index'));

        $this->assertTrue(Department::where('name', 'Test Department')->exists());
    }

    public function testUserCanEditDepartments()
    {
        $category = Category::factory()->forAssets()->create();
        $department = Department::factory()->create(['name' => 'Test Department']);
        $this->assertTrue(Department::where('name', 'Test Department')->exists());

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('departments.update', ['department' => $department]), [
                'name' => 'Test Department Edited',
                'category_id' => $department->category_id,
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('departments.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertTrue(Department::where('name', 'Test Department Edited')->exists());

    }



}
