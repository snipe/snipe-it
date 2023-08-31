<?php

namespace Tests\Feature\Api\Users;

use App\Models\Department;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UsersUpdateTest extends TestCase
{
    use InteractsWithSettings;


    public function testCanUpdateUserViaPatch()
    {
        $this->markTestIncomplete();
    }

    public function testCanUpdateUserViaPut()
    {
        $this->markTestIncomplete();
    }

    public function testDepartmentPatching()
    {
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->forDepartment(['name' => 'Department A'])->create();
        $department = Department::factory()->create();

        $this->actingAsForApi($admin)->patch(route('api.users.update', $user), [
            // This isn't valid but doesn't return an error
            'department_id' => ['id' => $department->id],
            // This is the correct syntax
            // 'department_id' => $department->id,
        ])->assertOk();

        $this->assertTrue(
            $user->fresh()->department()->is($department),
            'User is not associated with expected department'
        );
    }
}
