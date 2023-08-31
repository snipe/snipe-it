<?php

namespace Tests\Feature\Api\Users;

use App\Models\Department;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UsersUpdateTest extends TestCase
{
    use InteractsWithSettings;

    public function testSomething()
    {
        $this->withoutExceptionHandling();
        $admin = User::factory()->superuser()->create();
        $user = User::factory()->forDepartment(['name' => 'Department A'])->create();
        $department = Department::factory()->create();

        $this->actingAsForApi($admin)->patch(route('api.users.update', $user), [
            'department_id' => ['id' => $department->id]
        ])->assertOk();

        $this->assertTrue(
            $user->fresh()->department()->is($department),
            'User is not associated with expected department'
        );
    }
}
