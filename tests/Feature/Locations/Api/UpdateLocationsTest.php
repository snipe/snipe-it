<?php

namespace Tests\Feature\Locations\Api;

use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class UpdateLocationsTest extends TestCase
{

    public function testRequiresPermissionToEditLocation()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.locations.store', Location::factory()->create()))
            ->assertForbidden();
    }

    public function testCanUpdateLocationViaPatch()
    {
        $location = Location::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.locations.update', $location), [
                'name' => 'Test Location',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $location->refresh();
        $this->assertEquals('Test Location', $location->name, 'Name was not updated');

    }

    
}
