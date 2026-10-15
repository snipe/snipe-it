<?php

namespace Tests\Feature\Departments\Api;

use App\Models\Department;
use App\Models\User;
use Tests\TestCase;

class UpdateDepartmentsTest extends TestCase
{
    public function test_requires_permission_to_edit_department()
    {
        $department = Department::factory()->create();
        $this->actingAsForApi(User::factory()->create())
            ->patchJson(route('api.departments.update', $department))
            ->assertForbidden();
    }

    public function test_can_update_department_via_patch()
    {
        $department = Department::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.departments.update', $department), [
                'name' => 'Test Department',
                'notes' => 'Test Note',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $department->refresh();
        $this->assertEquals('Test Department', $department->name, 'Name was not updated');
        $this->assertEquals('Test Note', $department->notes, 'Note was not updated');

    }

    public function test_array_name_is_rejected_and_does_not_corrupt_row()
    {
        // Regression: the API PATCH endpoint used the generic ImageUploadRequest
        // which does not validate `name`, so a caller could send name as an
        // array. The model's max:255 rule counted array items instead of string
        // length, save() proceeded, JSON-encoded the array as the DB column
        // value, and then the transformer TypeErrored inside htmlspecialchars.
        // Fixed by tightening the model rule to require a string.
        $department = Department::factory()->create(['name' => 'Original Name']);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.departments.update', $department), [
                'name' => ['hax', 'hax2'],
            ])
            ->assertStatusMessageIs('error');

        $department->refresh();
        $this->assertSame(
            'Original Name',
            $department->name,
            'Row was corrupted by an array payload — validation failed to reject it.'
        );
    }
}
