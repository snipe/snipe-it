<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\License;
use App\Models\User;
use Tests\TestCase;

class CloneLicenseTest extends TestCase
{
    public function test_permission_required_to_clone_license(): void
    {
        $license = License::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('clone/license', $license))
            ->assertForbidden();
    }

    public function test_create_permission_alone_is_not_enough_to_clone_license(): void
    {
        // Cloning renders the source license's data (name, seats, order
        // number, purchase cost, notes, purchase date, supplier, category)
        // into the create form, so a user with only licenses.create (no
        // licenses.view) must be blocked.
        $license = License::factory()->create();

        $this->actingAs(User::factory()->createLicenses()->create())
            ->get(route('clone/license', $license))
            ->assertForbidden();
    }

    public function test_clone_page_renders_for_a_user_with_clone_permission_set(): void
    {
        $license = License::factory()->create();

        $this->actingAs(User::factory()->cloneLicenses()->create())
            ->get(route('clone/license', $license))
            ->assertOk();
    }
}
