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
                'name' => 'Test Updated Location',
                'notes' => 'Test Updated Note',
                'latitude' => '38.7532',
                'longitude' => '-77.1969'
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $location->refresh();
        $this->assertEquals('Test Updated Location', $location->name, 'Name was not updated');
        $this->assertEquals('Test Updated Note', $location->notes, 'Note was not updated');
        $this->assertEquals(38.7532, $location->latitude, 'Latitude was not updated');
        $this->assertEquals(-77.1969, $location->longitude, 'Longitude was not updated');
    }
    
}
