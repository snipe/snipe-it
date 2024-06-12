<?php

namespace Tests\Feature\Users;

use Illuminate\Support\Facades\Notification;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;
use App\Notifications\CurrentInventory;

class DeleteUserTest extends TestCase
{

    public function testPermissionsToDeleteUser()
    {

        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $userFromA = User::factory()->for($companyA)->create();
        $userFromB = User::factory()->for($companyB)->create();

        $this->followingRedirects()->actingAs(User::factory()->deleteUsers()->for($companyA)->create())
            ->delete(route('users.destroy', ['user' => $userFromB->id]))
            ->assertStatus(403);

        $this->actingAs(User::factory()->deleteUsers()->for($companyA)->create())
            ->delete(route('users.destroy', ['user' => $userFromA->id]))
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->actingAs($superuser)
            ->post(route('users.email', ['userId' => $userFromA->id]))
            ->assertStatus(302);

        $this->actingAs($superuser)
            ->post(route('users.email', ['userId' => $userFromB->id]))
            ->assertStatus(302);

    }


}
