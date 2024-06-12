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

        $this->actingAs(User::factory()->viewUsers()->create())
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

        $this->followingRedirects()->actingAsForApi(User::factory()->deleteUsers()->for($companyA)->create())
            ->delete(route('users.destroy', ['user' => $userFromB->id]))
            ->assertStatus(403);

        $this->actingAs(User::factory()->deleteUsers()->for($companyA)->create())
            ->delete(route('users.destroy', ['user' => $userFromA->id]))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->actingAs($superuser)
            ->post(route('users.destroy', ['userId' => $userFromA->id]))
            ->assertStatus(302);

        $this->actingAs($superuser)
            ->post(route('users.destroy', ['userId' => $userFromB->id]))
            ->assertStatus(302);

    }

}
