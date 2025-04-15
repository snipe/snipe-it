<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class UpdateLocationsTest extends TestCase
{
    public function testPermissionRequiredToStoreLocation()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('locations.store'), [
                'name' => 'Test Location',
            ])
            ->assertStatus(403)
            ->assertForbidden();
    }

    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('locations.edit', Location::factory()->create()))
            ->assertOk();
    }

    public function testUserCanEditLocations()
    {
        $location = Location::factory()->create(['name' => 'Test Location']);
        $this->assertTrue(Location::where('name', 'Test Location')->exists());

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('locations.update', ['location' => $location]), [
                'name' => 'Test Location Edited',
                'notes' => 'Test Note Edited',
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('locations.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertTrue(Location::where('name', 'Test Location Edited')->where('notes', 'Test Note Edited')->exists());
    }

    public function testUserCannotEditLocationsToMakeThemTheirOwnParent()
    {
        $location = Location::factory()->create();

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.edit', $location))
            ->put(route('locations.update', $location), [
                'name' => 'Test Location',
                'parent_id' => $location->id,
            ])
            ->assertRedirect(route('locations.edit', ['location' => $location]));

        $this->followRedirects($response)->assertSee(trans('general.error'));
        $this->assertFalse(Location::where('name', 'Test Location')->exists());
    }

    public function testUserCannotEditLocationsWithInvalidParent()
    {
        $location = Location::factory()->create();
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.edit', $location))
            ->put(route('locations.update', ['location' => $location]), [
                'name' => 'Test Location',
                'parent_id' => '100000000'
            ])
            ->assertRedirect(route('locations.edit', ['location' => $location->id]));

        $this->followRedirects($response)->assertSee(trans('general.error'));
        $this->assertFalse(Location::where('name', 'Test Location')->exists());
    }



}
