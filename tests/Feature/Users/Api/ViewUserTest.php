<?php

namespace Tests\Feature\Users\Api;

use App\Models\Company;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ViewUserTest extends TestCase
{

    public function testCanReturnUser()
    {
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->viewUsers()->create())
            ->getJson(route('api.users.show', $user))
            ->assertOk();
    }

    public function testPermissionsWithCompanyableToDeleteUser()
    {

        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $userFromA = User::factory()->for($companyA)->create();
        $userFromB = User::factory()->for($companyB)->create();

        $this->actingAsForApi(User::factory()->deleteUsers()->for($companyA)->create())
            ->deleteJson(route('api.users.destroy', $userFromA->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success')
            ->json();

        $this->actingAsForApi(User::factory()->deleteUsers()->for($companyB)->create())
            ->deleteJson(route('api.users.destroy', $userFromA->id))
            ->assertStatus(403);

        $this->actingAsForApi($superuser)
            ->deleteJson(route('api.users.destroy', $userFromA->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success')
            ->json();

        $this->actingAsForApi($superuser)
            ->deleteJson(route('api.users.destroy', $userFromB->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success')
            ->json();

    }

}
