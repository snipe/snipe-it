<?php

namespace Tests\Feature\Users\Ui;

use App\Models\Actionlog;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for the double-logging bug on the web-side user
 * restore endpoint. Pre-fix:
 *
 *   - The controller wrote a manual `restore` log after $user->restore().
 *   - UserObserver's `restoring` hook also wrote a `restore` log.
 *
 * Two log rows per restore instead of one. UserObserver's `updating`
 * hook did NOT contribute an extra "update" log on restore because it
 * uses an allowlist of trackable fields that never included
 * `deleted_at`. The manual controller write was removed to leave the
 * observer as the single log author.
 */
class RestoreUserTest extends TestCase
{
    public function test_permission_required_to_restore_user(): void
    {
        $user = User::factory()->deletedUser()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('users.restore.store', $user->id))
            ->assertForbidden();
    }

    public function test_soft_deleted_user_can_be_restored_via_web(): void
    {
        $user = User::factory()->deletedUser()->create();
        $this->assertNotNull($user->deleted_at);

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('users.restore.store', $user->id))
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertNull($user->fresh()->deleted_at);
    }

    public function test_restore_writes_exactly_one_restore_action_log(): void
    {
        $user = User::factory()->deletedUser()->create();

        $before = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'restore')
            ->count();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('users.restore.store', $user->id))
            ->assertRedirect();

        $after = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'restore')
            ->count();

        $this->assertSame($before + 1, $after, 'Expected exactly one restore action_log entry (regression: was 2 pre-fix, one from the controller and one from the observer).');
    }

    public function test_restore_does_not_write_an_update_action_log(): void
    {
        // UserObserver::updating uses an allowlist that excludes
        // deleted_at, so this test would have passed pre-fix as well.
        // Included as belt-and-suspenders against a future observer
        // change that switches to an unfiltered raw-original diff.
        $user = User::factory()->deletedUser()->create();

        $before = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->count();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('users.restore.store', $user->id))
            ->assertRedirect();

        $after = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->count();

        $this->assertSame($before, $after, 'Expected no update action_log entry on restore.');
    }
}
