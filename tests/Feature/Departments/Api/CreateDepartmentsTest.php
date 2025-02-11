<?php

namespace Tests\Feature\Departments\Api;

use App\Models\AssetModel;
use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateDepartmentsTest extends TestCase
{


    public function testRequiresPermissionToCreateDepartment()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.departments.store'))
            ->assertForbidden();
    }

    public function testCanCreateDepartment()
    {
        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.departments.store'), [
                'name' => 'Test Department',
                'notes' => 'Test Note',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $this->assertTrue(Department::where('name', 'Test Department')->exists());

        $department = Department::find($response['payload']['id']);
        $this->assertEquals('Test Department', $department->name);
        $this->assertEquals('Test Note', $department->notes);
    }

}
