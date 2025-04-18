<?php

namespace Tests\Feature\Locations\Api;

use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class CreateLocationsTest extends TestCase
{

    public function testRequiresPermissionToCreateLocation()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.departments.store'))
            ->assertForbidden();
    }


    public function testCanCreateLocation()
    {
        $response = $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.locations.store'), [
                'name' => 'Test Location',
                'notes' => 'Test Note',
                'latitude' => '38.7532',
                'longitude' => '-77.1969'
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->json();

        $this->assertTrue(Location::where('name', 'Test Location')->exists());

        $location = Location::find($response['payload']['id']);
        $this->assertEquals('Test Location', $location->name);
        $this->assertEquals('Test Note', $location->notes);
        $this->assertEquals(38.7532, $location->latitude);
        $this->assertEquals(-77.1969, $location->longitude);
    }

    public function testCannotCreateNewLocationsWithTheSameName()
    {
        $location = Location::factory()->create();
        $location2 = Location::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.locations.update', $location2), [
                'name' => $location->name,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();


    }

    public function testUserCannotCreateLocationsThatAreTheirOwnParent()
    {
        $location = Location::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->patchJson(route('api.locations.update', $location), [
                'parent_id' => $location->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertJson([
                'messages' => [
                    'parent_id'    => ['The parent id must not create a circular reference.'],
                ],
            ])
            ->json();


    }

}
