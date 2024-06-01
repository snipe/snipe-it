<?php

namespace Tests\Feature\Api\Users;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use App\Models\LicenseSeat;
use Tests\TestCase;

class DeleteUsersTest extends TestCase
{


    public function testDisallowUserDeletionViaApiIfStillManagingPeople()
    {
        $manager = User::factory()->create();
        User::factory()->count(5)->create(['manager_id' => $manager->id]);
        $this->assertFalse($manager->isDeletable());

        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->deleteJson(route('api.users.destroy', $manager->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testDisallowUserDeletionViaApiIfStillManagingLocations()
    {
        $manager = User::factory()->create();
        Location::factory()->count(5)->create(['manager_id' => $manager->id]);

        $this->assertFalse($manager->isDeletable());

        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->deleteJson(route('api.users.destroy', $manager->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testDisallowUserDeletionViaApiIfStillHasLicenses()
    {
        $manager = User::factory()->create();
        LicenseSeat::factory()->count(5)->create(['assigned_to' => $manager->id]);

        $this->assertFalse($manager->isDeletable());

        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->deleteJson(route('api.users.destroy', $manager->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testDisallowUserDeletionIfNoDeletePermissions()
    {

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.users.destroy', User::factory()->create()))
            ->assertStatus(403)
            ->json();
    }

    public function testDisallowUserDeletionIfNotInSameCompanyAndNotSuperadmin()
    {
        $this->settings->enableMultipleFullCompanySupport();
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->deleteUsers()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->deleteUsers()->make());

        $this->actingAsForApi($userInCompanyA)
            ->deleteJson(route('api.users.destroy', $userInCompanyB))
            ->assertStatus(403)
            ->json();

        $this->actingAsForApi($userInCompanyB)
            ->deleteJson(route('api.users.destroy', $userInCompanyA))
            ->assertStatus(403)
            ->json();

        $this->actingAsForApi($superUser)
            ->deleteJson(route('api.users.destroy', $userInCompanyA))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success')
            ->json();

    }

    public function testUsersCannotDeleteThemselves()
    {
        $user = User::factory()->deleteUsers()->create();
        $this->actingAsForApi($user)
            ->deleteJson(route('api.users.destroy', $user))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();

    }







}
