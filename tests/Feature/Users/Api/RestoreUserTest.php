<?php

namespace Tests\Feature\Users\Api;

use App\Models\Actionlog;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class RestoreUserTest extends TestCase
{
    public function test_error_returned_via_api_if_user_does_not_exist()
    {
        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->postJson(route('api.users.restore', 'invalid-id'))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function test_error_returned_via_api_if_user_is_not_deleted()
    {
        $user = User::factory()->create();
        $this->actingAsForApi(User::factory()->deleteUsers()->create())
            ->postJson(route('api.users.restore', $user->id))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();
    }

    public function test_denied_permissions_for_restoring_user_via_api()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.users.restore', User::factory()->deletedUser()->create()))
            ->assertStatus(403)
            ->json();
    }

    public function test_success_permissions_for_restoring_user_via_api()
    {
        $deleted_user = User::factory()->deletedUser()->create();

        $this->actingAsForApi(User::factory()->admin()->create())
            ->postJson(route('api.users.restore', ['user' => $deleted_user]))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success')
            ->json();

        $deleted_user->refresh();
        $this->assertNull($deleted_user->deleted_at);
    }

    public function test_restore_writes_exactly_one_restore_action_log(): void
    {
        // Regression for the double-logging bug: pre-fix the controller
        // wrote a manual `restore` log AND UserObserver::restoring wrote
        // one, so a single restore left two rows. Manual write removed
        // to leave the observer as the sole author.
        $deleted_user = User::factory()->deletedUser()->create();

        $before = Actionlog::where('item_type', User::class)
            ->where('item_id', $deleted_user->id)
            ->where('action_type', 'restore')
            ->count();

        $this->actingAsForApi(User::factory()->admin()->create())
            ->postJson(route('api.users.restore', ['user' => $deleted_user]))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $after = Actionlog::where('item_type', User::class)
            ->where('item_id', $deleted_user->id)
            ->where('action_type', 'restore')
            ->count();

        $this->assertSame($before + 1, $after, 'Expected exactly one restore action_log entry (regression: was 2 pre-fix).');
    }

    public function test_restore_does_not_write_an_update_action_log(): void
    {
        // UserObserver::updating uses an allowlist that excludes
        // deleted_at, so this test would have passed pre-fix as well.
        // Included as belt-and-suspenders against a future observer
        // change that switches to an unfiltered raw-original diff.
        $deleted_user = User::factory()->deletedUser()->create();

        $before = Actionlog::where('item_type', User::class)
            ->where('item_id', $deleted_user->id)
            ->where('action_type', 'update')
            ->count();

        $this->actingAsForApi(User::factory()->admin()->create())
            ->postJson(route('api.users.restore', ['user' => $deleted_user]))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $after = Actionlog::where('item_type', User::class)
            ->where('item_id', $deleted_user->id)
            ->where('action_type', 'update')
            ->count();

        $this->assertSame($before, $after, 'Expected no update action_log entry on restore.');
    }

    public function test_permissions_for_restoring_if_not_in_same_company_and_not_superadmin()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $userFromA = User::factory()->deletedUser()->deleteUsers()->forCompany($companyA)->create();
        $userFromB = User::factory()->deletedUser()->deleteUsers()->forCompany($companyB)->create();

        $this->actingAsForApi($userFromA)
            ->postJson(route('api.users.restore', ['user' => $userFromB->id]))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();

        $userFromB->refresh();
        $this->assertNotNull($userFromB->deleted_at);

        $this->actingAsForApi($userFromB)
            ->postJson(route('api.users.restore', ['user' => $userFromA->id]))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('error')
            ->json();

        $userFromA->refresh();
        $this->assertNotNull($userFromA->deleted_at);

        $this->actingAsForApi($superuser)
            ->postJson(route('api.users.restore', ['user' => $userFromA->id]))
            ->assertOk()
            ->assertStatus(200)
            ->assertStatusMessageIs('success')
            ->json();

        $userFromA->refresh();
        $this->assertNull($userFromA->deleted_at);

    }
}
