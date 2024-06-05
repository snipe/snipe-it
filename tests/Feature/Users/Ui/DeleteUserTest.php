<?php

namespace Tests\Feature\Users\Ui;

use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{


    public function testDisallowUserDeletionIfStillManagingPeople()
    {
        $manager = User::factory()->create();
        User::factory()->count(3)->create(['manager_id' => $manager->id]);

        $this->actingAs(User::factory()->deleteUsers()->create())->assertFalse($manager->isDeletable());

        $response = $this->actingAs(User::factory()->deleteUsers()->viewUsers()->create())
            ->delete(route('users.destroy', $manager->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Error');
    }

    public function testDisallowUserDeletionIfStillManagingLocations()
    {
        $manager = User::factory()->create();
        Location::factory()->count(3)->create(['manager_id' => $manager->id]);

        $this->actingAs(User::factory()->deleteUsers()->create())->assertFalse($manager->isDeletable());

        $response = $this->actingAs(User::factory()->deleteUsers()->viewUsers()->create())
            ->delete(route('users.destroy', $manager->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

           $this->followRedirects($response)->assertSee('Error');
    }

    public function testDisallowUserDeletionIfStillHaveAccessories()
    {
        $user = User::factory()->create();
        Accessory::factory()->count(3)->create(['assigned_to' => $user->id]);

        $this->actingAs(User::factory()->deleteUsers()->create())->assertFalse($user->isDeletable());

        $response = $this->actingAs(User::factory()->deleteUsers()->viewUsers()->create())
            ->delete(route('users.destroy', $user->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Error');
    }

    public function testDisallowUserDeletionIfStillHaveLicenses()
    {
        $user = User::factory()->create();
        LicenseSeat::factory()->count(3)->create(['assigned_to' => $user->id]);

        $this->actingAs(User::factory()->deleteUsers()->create())->assertFalse($user->isDeletable());

        $response = $this->actingAs(User::factory()->deleteUsers()->viewUsers()->create())
            ->delete(route('users.destroy', $user->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Error');
    }


    public function testAllowUserDeletionIfNotManagingLocations()
    {
        $manager = User::factory()->create();
        $this->actingAs(User::factory()->deleteUsers()->create())->assertTrue($manager->isDeletable());

        $response = $this->actingAs(User::factory()->deleteUsers()->viewUsers()->create())
            ->delete(route('users.destroy', $manager->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Success');

    }

    public function testDisallowUserDeletionIfNoDeletePermissions()
    {
        $manager = User::factory()->create();
        Location::factory()->create(['manager_id' => $manager->id]);
        $this->actingAs(User::factory()->editUsers()->create())->assertFalse($manager->isDeletable());
    }

    public function testUsersCannotDeleteThemselves()
    {
        $manager = User::factory()->deleteUsers()->create();
        $this->actingAs(User::factory()->deleteUsers()->create())->assertTrue($manager->isDeletable());

        $response = $this->actingAs($manager)
            ->delete(route('users.destroy', $manager->id))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->followRedirects($response)->assertSee('Error');
    }


}
