<?php

namespace Tests\Feature\Api\Users;

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



}
