<?php

namespace Tests\Feature\Locations\Api;

use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class DeleteLocationsTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $location = Location::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->deleteJson(route('api.locations.destroy', $location))
            ->assertForbidden();

        $this->assertNotSoftDeleted($location);
    }

    public function testErrorReturnedViaApiIfLocationDoesNotExist()
    {
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.users.destroy', 'invalid-id'))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testErrorReturnedViaApiIfLocationIsAlreadyDeleted()
    {
        $location = Location::factory()->deletedLocation()->create();
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.locations.destroy', $location->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testDisallowLocationDeletionViaApiIfStillHasPeople()
    {
        $location = Location::factory()->create();
        User::factory()->count(5)->create(['location_id' => $location->id]);

        $this->assertFalse($location->isDeletable());

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.locations.destroy', $location->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testDisallowUserDeletionViaApiIfStillHasChildLocations()
    {
        $parent = Location::factory()->create();
        Location::factory()->count(5)->create(['parent_id' => $parent->id]);
        $this->assertFalse($parent->isDeletable());

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.locations.destroy', $parent->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testDisallowUserDeletionViaApiIfStillHasAssetsAssigned()
    {
        $location = Location::factory()->create();
        Asset::factory()->count(5)->assignedToLocation($location)->create();

        $this->assertFalse($location->isDeletable());

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.locations.destroy', $location->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testDisallowUserDeletionViaApiIfStillHasAssetsAsLocation()
    {
        $location = Location::factory()->create();
        Asset::factory()->count(5)->create(['location_id' => $location->id]);

        $this->assertFalse($location->isDeletable());

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.locations.destroy', $location->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function testCanDeleteLocation()
    {
        $location = Location::factory()->create();

        $this->actingAsForApi(User::factory()->deleteLocations()->create())
            ->deleteJson(route('api.locations.destroy', $location->id))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSoftDeleted($location);
    }
}
