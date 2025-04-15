<?php

namespace Tests\Feature\Users\Api;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreUsersTest extends TestCase
{
    public function testRequiresPermission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.users.store'), [
                'first_name' => 'Joe',
                'username' => 'joe',
                'password' => 'joe_password',
                'password_confirmation' => 'joe_password',
            ])
            ->assertForbidden();
    }

    public function testCompanyIdNeedsToBeInteger()
    {
        $company = Company::factory()->create();

        $this->actingAsForApi(User::factory()->createUsers()->create())
            ->postJson(route('api.users.store'), [
                'company_id' => [$company->id],
                'first_name' => 'Joe',
                'username' => 'joe',
                'password' => 'joe_password',
                'password_confirmation' => 'joe_password',
            ])
            ->assertStatusMessageIs('error')
            ->assertJson(function (AssertableJson $json) {
                $json->has('messages.company_id')->etc();
            });
    }

    public function testDepartmentIdNeedsToBeInteger()
    {
        $department = Department::factory()->create();

        $this->actingAsForApi(User::factory()->createUsers()->create())
            ->postJson(route('api.users.store'), [
                'department_id' => [$department->id],
                'first_name' => 'Joe',
                'username' => 'joe',
                'password' => 'joe_password',
                'password_confirmation' => 'joe_password',
            ])
            ->assertStatusMessageIs('error')
            ->assertJson(function (AssertableJson $json) {
                $json->has('messages.department_id')->etc();
            });
    }

    public function testCanStoreUser()
    {
        $this->actingAsForApi(User::factory()->createUsers()->create())
            ->postJson(route('api.users.store'), [
                'first_name' => 'Darth',
                'username' => 'darthvader',
                'password' => 'darth_password',
                'password_confirmation' => 'darth_password',
            ])
            ->assertStatusMessageIs('success')
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'first_name' => 'Darth',
            'username' => 'darthvader',
        ]);
    }
}
