<?php

namespace Tests\Feature\Users\Api;

use App\Models\User;
use Tests\TestCase;

/**
 * Verifies the per-row eligibility flags that drive the users index bulk-actions
 * dropdown. `available_actions.bulk_selectable` exposes 6 keys (edit,
 * send_assigned, delete, merge, bulkpasswordreset, print); the dropdown
 * intersects them across selected rows. Per-row gates in UsersTransformer mirror
 * the actual per-row filters in BulkUsersController::edit (email presence for
 * send_assigned; email + activated + not ldap_import for bulkpasswordreset).
 */
class BulkSelectableTest extends TestCase
{
    public function test_clean_user_supports_all_six_actions()
    {
        $user = User::factory()->create([
            'email' => 'user@example.test',
            'activated' => 1,
            'ldap_import' => 0,
        ]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.users.show', $user))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.send_assigned', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', true)
            ->assertJsonPath('available_actions.bulk_selectable.merge', true)
            ->assertJsonPath('available_actions.bulk_selectable.bulkpasswordreset', true)
            ->assertJsonPath('available_actions.bulk_selectable.print', true);
    }

    public function test_soft_deleted_user_supports_none()
    {
        // api.users.show excludes soft-deleted rows, so we assert via the
        // index endpoint with deleted=true which does return them.
        $user = User::factory()->create([
            'username' => 'unique-'.uniqid(),
            'email' => 'user@example.test',
            'activated' => 1,
            'ldap_import' => 0,
        ]);
        $user->delete();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.users.index', ['deleted' => 'true', 'search' => $user->username]))
            ->assertOk()
            ->assertJsonPath('rows.0.id', $user->id)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.edit', false)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.send_assigned', false)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.delete', false)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.merge', false)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.bulkpasswordreset', false)
            ->assertJsonPath('rows.0.available_actions.bulk_selectable.print', false);
    }

    public function test_user_without_email_cannot_send_assigned_or_password_reset()
    {
        $user = User::factory()->create([
            'email' => '',
            'activated' => 1,
            'ldap_import' => 0,
        ]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.users.show', $user))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.send_assigned', false)
            ->assertJsonPath('available_actions.bulk_selectable.bulkpasswordreset', false)
            ->assertJsonPath('available_actions.bulk_selectable.edit', true)
            ->assertJsonPath('available_actions.bulk_selectable.delete', true)
            ->assertJsonPath('available_actions.bulk_selectable.print', true);
    }

    public function test_deactivated_user_cannot_receive_password_reset()
    {
        $user = User::factory()->create([
            'email' => 'user@example.test',
            'activated' => 0,
            'ldap_import' => 0,
        ]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.users.show', $user))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.bulkpasswordreset', false)
            ->assertJsonPath('available_actions.bulk_selectable.send_assigned', true);
    }

    public function test_ldap_imported_user_cannot_receive_password_reset()
    {
        $user = User::factory()->create([
            'email' => 'user@example.test',
            'activated' => 1,
            'ldap_import' => 1,
        ]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.users.show', $user))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.bulkpasswordreset', false)
            ->assertJsonPath('available_actions.bulk_selectable.send_assigned', true);
    }

    public function test_user_without_edit_permission_gets_edit_and_send_assigned_false()
    {
        $user = User::factory()->create([
            'email' => 'user@example.test',
            'activated' => 1,
            'ldap_import' => 0,
        ]);

        $this->actingAsForApi(User::factory()->viewUsers()->create())
            ->getJson(route('api.users.show', $user))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.edit', false)
            ->assertJsonPath('available_actions.bulk_selectable.send_assigned', false)
            ->assertJsonPath('available_actions.bulk_selectable.print', true)
            ->assertJsonPath('available_actions.bulk_selectable.bulkpasswordreset', true);
    }

    public function test_user_without_delete_permission_gets_delete_and_merge_false()
    {
        $user = User::factory()->create([
            'email' => 'user@example.test',
            'activated' => 1,
            'ldap_import' => 0,
        ]);

        $this->actingAsForApi(User::factory()->viewUsers()->create())
            ->getJson(route('api.users.show', $user))
            ->assertOk()
            ->assertJsonPath('available_actions.bulk_selectable.delete', false)
            ->assertJsonPath('available_actions.bulk_selectable.merge', false)
            ->assertJsonPath('available_actions.bulk_selectable.print', true);
    }
}
