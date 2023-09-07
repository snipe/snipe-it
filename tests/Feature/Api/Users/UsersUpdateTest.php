<?php

namespace Tests\Feature\Api\Users;

use App\Models\Company;
use App\Models\Department;
use App\Models\Group;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UsersUpdateTest extends TestCase
{
    use InteractsWithSettings;

    public function testCanUpdateUserViaPatch()
    {
        $admin = User::factory()->superuser()->create();
        $manager = User::factory()->create();
        $company = Company::factory()->create();
        $department = Department::factory()->create();
        $location = Location::factory()->create();
        [$groupA, $groupB] = Group::factory()->count(2)->create();

        $user = User::factory()->create([
            'activated' => false,
            'remote' => false,
            'vip' => false,
        ]);

        $this->actingAsForApi($admin)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => 'Mabel',
                'last_name' => 'Mora',
                'username' => 'mabel',
                'password' => 'super-secret',
                'email' => 'mabel@onlymurderspod.com',
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
                'groups' => $groupA->id,
                'vip' => true,
                'start_date' => '2021-08-01',
                'end_date' => '2025-12-31',
            ])
            ->assertOk();

        $user->refresh();
        $this->assertEquals('Mabel', $user->first_name, 'First name was not updated');
        $this->assertEquals('Mora', $user->last_name, 'Last name was not updated');
        $this->assertEquals('mabel', $user->username, 'Username was not updated');
        $this->assertTrue(Hash::check('super-secret', $user->password), 'Password was not updated');
        $this->assertEquals('mabel@onlymurderspod.com', $user->email, 'Email was not updated');
        $this->assertArrayHasKey('a.new.permission', $user->decodePermissions(), 'Permissions were not updated');
        $this->assertTrue((bool)$user->activated, 'User not marked as activated');
        $this->assertEquals('619-555-5555', $user->phone, 'Phone was not updated');
        $this->assertEquals('Host', $user->jobtitle, 'Job title was not updated');
        $this->assertTrue($user->manager->is($manager), 'Manager was not updated');
        $this->assertEquals('1111', $user->employee_num, 'Employee number was not updated');
        $this->assertEquals('Pretty good artist', $user->notes, 'Notes was not updated');
        $this->assertTrue($user->company->is($company), 'Company was not updated');
        $this->assertTrue($user->department->is($department), 'Department was not updated');
        $this->assertTrue($user->location->is($location), 'Location was not updated');
        $this->assertEquals(1, $user->remote, 'Remote was not updated');
        $this->assertTrue($user->groups->contains($groupA), 'Groups were not updated');
        $this->assertEquals(1, $user->vip, 'VIP was not updated');
        $this->assertEquals('2021-08-01', $user->start_date, 'Start date was not updated');
        $this->assertEquals('2025-12-31', $user->end_date, 'End date was not updated');

        // `groups` can be an id or array or ids
        $this->patch(route('api.users.update', $user), ['groups' => [$groupA->id, $groupB->id]]);

        $user->refresh();
        $this->assertTrue($user->groups->contains($groupA), 'Not part of expected group');
        $this->assertTrue($user->groups->contains($groupB), 'Not part of expected group');
    }
}
