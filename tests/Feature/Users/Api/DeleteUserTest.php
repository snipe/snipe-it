<?php

namespace Tests\Feature\Users\Api;

use App\Models\Company;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{

    public function testUserCanDeleteAnotherUserViaApi()
    {

        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->deleteJson(route('api.users.destroy', User::factory()->create()))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success')
            ->json();
    }


    public function testErrorReturnedViaApiIfUserDoesNotExist()
    {
        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->deleteJson(route('api.users.destroy', 'invalid-id'))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testErrorReturnedViaApiIfUserIsAlreadyDeleted()
    {
        $user = User::factory()->deletedUser()->create();
        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->deleteJson(route('api.users.destroy', $user->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }


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

    public function testPermissionsForDeletingUsers()
    {

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.users.destroy', User::factory()->create()))
            ->assertStatus(403)
            ->json();
    }

    public function testPermissionsIfNotInSameCompanyAndNotSuperadmin()
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
