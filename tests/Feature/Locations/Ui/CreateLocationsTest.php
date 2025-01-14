<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Location;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CreateLocationsTest extends TestCase
{
    public function testPermissionRequiredToCreateLocation()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('locations.store'), [
                'name' => 'Test Location',
                'company_id' => Company::factory()->create()->id
            ])
            ->assertForbidden();
    }

    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('locations.create'))
            ->assertOk();
    }

    public function testUserCanCreateLocations()
    {
        $this->assertFalse(Location::where('name', 'Test Location')->exists());

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.store'), [
                'name' => 'Test Location',
                'company_id' => Company::factory()->create()->id
            ])
            ->assertRedirect(route('locations.index'));

        $this->assertTrue(Location::where('name', 'Test Location')->exists());
    }

    public function testUserCannotCreateLocationsWithInvalidParent()
    {
        $this->assertFalse(Location::where('name', 'Test Location')->exists());

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.create'))
            ->post(route('locations.store'), [
                'name' => 'Test Location',
                'parent_id' => '100000000'
            ])
            ->assertRedirect(route('locations.create'));

        $this->assertFalse(Location::where('name', 'Test Location')->exists());
    }

}
