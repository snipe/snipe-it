<?php

namespace Tests\Feature\Users\Ui;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CloneUserTest extends TestCase
{
    public function test_page_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('users.clone.show', User::factory()->create()))
            ->assertOk();
    }

    public function test_clone_prepopulates_all_companies_for_multi_company_user()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $user = User::factory()->forCompany($companyA->id)->create();
        $user->companies()->sync([$companyA->id, $companyB->id]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('users.clone.show', $user))
            ->assertOk();

        // Both company IDs should be pre-selected in the form.
        $response->assertSee('value="'.$companyA->id.'"', false);
        $response->assertSee('value="'.$companyB->id.'"', false);
    }

    public function test_create_permission_alone_is_not_enough_to_clone_user()
    {
        // Cloning renders the source user's data (email domain, groups,
        // permissions bitmap) into the create form, so a user with only
        // users.create (no users.view) must be blocked.
        $source = User::factory()->create();

        $this->actingAs(User::factory()->createUsers()->create())
            ->get(route('users.clone.show', $source))
            ->assertForbidden();
    }
}
