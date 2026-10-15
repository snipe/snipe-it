<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Tests\TestCase;

class ImpersonationSettingsRowTest extends TestCase
{
    public function test_row_shows_disabled_state_when_no_usernames_configured()
    {
        config(['app.user_impersonation_usernames' => []]);

        $admin = User::factory()->superuser()->create();

        $this->actingAs($admin)
            ->get(route('settings.index'))
            ->assertOk()
            ->assertSee(trans('admin/settings/general.user_impersonation'))
            ->assertSee(trans('admin/settings/general.user_impersonation_disabled'));
    }

    public function test_row_lists_a_valid_superuser_without_warnings()
    {
        $allowed = User::factory()->superuser()->create(['username' => 'allowed_super']);
        config(['app.user_impersonation_usernames' => [$allowed->username]]);

        $admin = User::factory()->superuser()->create();

        $this->actingAs($admin)
            ->get(route('settings.index'))
            ->assertOk()
            ->assertSee($allowed->display_name)
            ->assertSee($allowed->username)
            ->assertDontSee(trans('admin/settings/general.user_impersonation_not_superuser'))
            ->assertDontSee(trans('admin/settings/general.user_impersonation_missing'));
    }

    public function test_row_flags_non_superuser_in_allowlist()
    {
        $notSuper = User::factory()->admin()->create(['username' => 'not_super']);
        config(['app.user_impersonation_usernames' => [$notSuper->username]]);

        $admin = User::factory()->superuser()->create();

        $this->actingAs($admin)
            ->get(route('settings.index'))
            ->assertOk()
            ->assertSee($notSuper->display_name)
            ->assertSee(trans('admin/settings/general.user_impersonation_not_superuser'));
    }

    public function test_row_flags_missing_username()
    {
        config(['app.user_impersonation_usernames' => ['ghost_admin']]);

        $admin = User::factory()->superuser()->create();

        $this->actingAs($admin)
            ->get(route('settings.index'))
            ->assertOk()
            ->assertSee('ghost_admin')
            ->assertSee(trans('admin/settings/general.user_impersonation_missing'));
    }

    public function test_row_case_insensitively_matches_usernames()
    {
        $allowed = User::factory()->superuser()->create(['username' => 'SnipeAdmin']);
        config(['app.user_impersonation_usernames' => ['snipeadmin']]);

        $admin = User::factory()->superuser()->create();

        $this->actingAs($admin)
            ->get(route('settings.index'))
            ->assertOk()
            ->assertSee($allowed->display_name)
            ->assertDontSee(trans('admin/settings/general.user_impersonation_missing'));
    }
}
