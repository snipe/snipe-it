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
        $this->assertEquals('Mabel', $user->first_name);
        $this->assertEquals('Mora', $user->last_name);
        $this->assertEquals('mabel', $user->username);
        $this->assertTrue(Hash::check('super-secret', $user->password));
        $this->assertEquals('mabel@onlymurderspod.com', $user->email);
        $this->assertArrayHasKey('a.new.permission', $user->decodePermissions());
        $this->assertTrue($user->activated);
        $this->assertEquals('619-555-5555', $user->phone);
        $this->assertEquals('Host', $user->jobtitle);
        $this->assertTrue($user->manager->is($manager));
        $this->assertEquals('1111', $user->employee_num);
        $this->assertEquals('Pretty good artist', $user->notes);
        $this->assertTrue($user->company->is($company));
        $this->assertTrue($user->department->is($department));
        $this->assertTrue($user->location->is($location));
        $this->assertEquals(1, $user->remote);
        $this->assertTrue($user->groups->contains($groupA));
        $this->assertTrue($user->vip);
        $this->assertEquals('2021-08-01', $user->start_date);
        $this->assertEquals('2025-12-31', $user->end_date);

        // `groups` can be an id or array or ids
        $this->patch(route('api.users.update', $user), ['groups' => [$groupA->id, $groupB->id]]);

        $user->refresh();
        $this->assertTrue($user->groups->contains($groupA));
        $this->assertTrue($user->groups->contains($groupB));
    }
}
