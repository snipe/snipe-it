<?php

namespace Tests\Feature\Api\Users;

use App\Models\Location;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UsersDeleteTest extends TestCase
{


    public function testDisallowUserDeletionIfStillManagingPeople()
    {
        $manager = User::factory()->create(['first_name' => 'Manager', 'last_name' => 'McManagerson']);
        User::factory()->create(['first_name' => 'Lowly', 'last_name' => 'Worker', 'manager_id' => $manager->id]);
        $this->actingAs(User::factory()->deleteUsers()->create())->assertFalse($manager->isDeletable());
    }

    public function testDisallowUserDeletionIfStillManagingLocations()
    {
        $manager = User::factory()->create(['first_name' => 'Manager', 'last_name' => 'McManagerson']);
        Location::factory()->create(['manager_id' => $manager->id]);
        $this->actingAs(User::factory()->deleteUsers()->create())->assertFalse($manager->isDeletable());
    }

    public function testAllowUserDeletionIfNotManagingLocations()
    {
        $manager = User::factory()->create(['first_name' => 'Manager', 'last_name' => 'McManagerson']);
        $this->actingAs(User::factory()->deleteUsers()->create())->assertTrue($manager->isDeletable());
    }

    public function testDisallowUserDeletionIfNoDeletePermissions()
    {
        $manager = User::factory()->create(['first_name' => 'Manager', 'last_name' => 'McManagerson']);
        Location::factory()->create(['manager_id' => $manager->id]);
        $this->actingAs(User::factory()->editUsers()->create())->assertFalse($manager->isDeletable());
    }


}
