<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class CloneLocationTest extends TestCase
{
    public function test_permission_required_to_clone_location(): void
    {
        $location = Location::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('clone/location', $location))
            ->assertForbidden();
    }

    public function test_create_permission_alone_is_not_enough_to_clone_location(): void
    {
        // Cloning renders the source location's data (name, address, city,
        // state, phone, manager) into the create form, so a user with only
        // locations.create (no locations.view) must be blocked.
        $location = Location::factory()->create();

        $this->actingAs(User::factory()->createLocations()->create())
            ->get(route('clone/location', $location))
            ->assertForbidden();
    }

    public function test_clone_page_renders_for_a_user_with_clone_permission_set(): void
    {
        $location = Location::factory()->create();

        $this->actingAs(User::factory()->cloneLocations()->create())
            ->get(route('clone/location', $location))
            ->assertOk();
    }
}
