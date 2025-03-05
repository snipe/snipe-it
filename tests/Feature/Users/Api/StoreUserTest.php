<?php

namespace Tests\Feature\Users\Api;

use App\Models\Company;
use App\Models\Department;
use App\Models\Group;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class StoreUserTest extends TestCase {
    public function testRequiresPermission()
    {

        $request = $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.users.store'))
            ->assertForbidden()
            ->json();
    }

    public function testCanSaveUserViaPost()
    {
        $admin = User::factory()->superuser()->create();
        $manager = User::factory()->create();
        $company = Company::factory()->create();
        $department = Department::factory()->create();
        $location = Location::factory()->create();
        $group = Group::factory()->create();


        $response = $this->actingAsForApi($admin)
            ->postJson(route('api.users.store'), [
                'first_name' => 'Mabel',
                'last_name' => 'Mora',
                'username' => 'mabel',
                'password' => 'super-secret',
                'password_confirmation' => 'super-secret',
                'email' => 'mabel@example.com',
                'permissions' => '{"a.new.permission":"1"}',
                'activated' => true,
                'phone' => '619-555-5555',
                'jobtitle' => 'Host',
                'manager_id' => $manager->id,
                'employee_num' => '1111',
                'notes' => 'Pretty good artist',
                'company_id' => $company->id,
                'department_id' => $department->id,
                'location_id' => $location->id,
                'remote' => true,
                'groups' => $group->id,
                'vip' => true,
                'start_date' => '2021-08-01',
                'end_date' => '2025-12-31',
            ])
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success');

        $user = User::find($response['payload']['id']);
        $this->assertEquals($admin->id, $user->created_by, 'Created by was not saved');
    }

    public function testDoesNotAcceptBogusGroupData()
    {
        $admin = User::factory()->superuser()->create();

        $this->actingAsForApi($admin)
            ->postJson(route('api.users.store'), [
                'first_name' => 'Mabel',
                'username' => 'mabel',
                'password' => 'super-secret',
                'password_confirmation' => 'super-secret',
                'groups' => ['blah'],
            ])
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->assertJson(
                [
                    'messages' =>  [
                        'groups' =>
                            [0 => trans('The selected groups is invalid.')]
                        ]
                ])
            ->json();

    }


}
