<?php

namespace Tests\Feature\Departments\Ui;

use App\Models\Department;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

final class CreateDepartmentsTest extends TestCase
{
    public function testPermissionRequiredToCreateDepartment(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('departments.store'), [
                'name' => 'Test Department',
                'company_id' => Company::factory()->create()->id
            ])
            ->assertForbidden();
    }

    public function testUserCanCreateDepartments(): void
    {
        $this->assertFalse(Department::where('name', 'Test Department')->exists());

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('departments.store'), [
                'name' => 'Test Department',
                'company_id' => Company::factory()->create()->id
            ])
            ->assertRedirect(route('departments.index'));

        $this->assertTrue(Department::where('name', 'Test Department')->exists());
    }


}
