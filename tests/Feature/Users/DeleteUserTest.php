<?php

namespace Tests\Feature\Users;

use Illuminate\Support\Facades\Notification;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;
use App\Notifications\CurrentInventory;

class DeleteUserTest extends TestCase
{

    public function testUserWithoutCompanyPermissionsCannotViewPrintAllInventoryPage()
    {
        $this->settings->enableMultipleFullCompanySupport();
        //$this->withoutExceptionHandling();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $user = User::factory()->for($companyB)->create();

        $this->actingAs(User::factory()->viewUsers()->for($companyA)->create())
            ->get(route('users.print', ['userId' => $user->id]))
            ->assertStatus(403);

        $this->actingAs(User::factory()->viewUsers()->for($companyB)->create())
            ->get(route('users.print', ['userId' => $user->id]))
            ->assertStatus(200);

        $this->actingAs($superuser)
            ->get(route('users.print', ['userId' => $user->id]))
            ->assertOk()
            ->assertStatus(200);
    }

    public function testUserWithoutCompanyPermissionsCannotSendInventory()
    {
        Notification::fake();

        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $user = User::factory()->for($companyB)->create();

        $this->actingAs(User::factory()->viewUsers()->for($companyA)->create())
            ->post(route('users.email', ['userId' => $user->id]))
            ->assertStatus(403);

        $this->actingAs(User::factory()->viewUsers()->for($companyB)->create())
            ->post(route('users.email', ['userId' => $user->id]))
            ->assertStatus(302);

        $this->actingAs($superuser)
            ->post(route('users.email', ['userId' => $user->id]))
            ->assertStatus(302);

        Notification::assertSentTo(
            [$user], CurrentInventory::class
        );
    }

    public function testUserWithoutCompanyPermissionsCannotDeleteUser()
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
