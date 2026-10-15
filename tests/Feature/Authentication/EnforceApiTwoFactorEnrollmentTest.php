<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Confirms that Personal Access Tokens (or any Passport-authenticated API
 * request) can't be used to call the API when the token's owner hasn't
 * satisfied the org's 2FA policy. Complements
 * PersonalAccessTokenTwoFactorGuardTest, which covers the acquisition step
 * (can't mint a PAT without clearing 2FA in-session); this file covers the
 * usage step (can't use a PAT when the owner isn't 2FA-enrolled and the org
 * setting requires enrollment).
 */
class EnforceApiTwoFactorEnrollmentTest extends TestCase
{
    public function test_disabled_two_factor_lets_any_pat_through()
    {
        // '' == disabled globally. Even an unenrolled superuser's PAT works,
        // matching the behavior of installs that haven't turned 2FA on.
        $this->settings->set(['two_factor_enabled' => '']);
        $user = User::factory()->superuser()->create([
            'two_factor_enrolled' => '0',
            'two_factor_optin' => '0',
        ]);

        Passport::actingAs($user);

        $this->getJson(route('api.users.me'))->assertOk();
    }

    public function test_optional_two_factor_lets_non_optin_users_through()
    {
        // Mode 1: 2FA optional. A user who hasn't opted in must not be forced
        // into 403 territory by this middleware — that would break every
        // legacy PAT the moment an admin flips optional 2FA on.
        $this->settings->set(['two_factor_enabled' => '1']);
        $user = User::factory()->superuser()->create([
            'two_factor_enrolled' => '0',
            'two_factor_optin' => '0',
        ]);

        Passport::actingAs($user);

        $this->getJson(route('api.users.me'))->assertOk();
    }

    public function test_optional_two_factor_blocks_optin_users_who_are_not_enrolled()
    {
        // Mode 1 + opted in but never finished enrollment = same policy state
        // as required mode: token owner has committed to 2FA but the second
        // factor isn't actually usable yet.
        $this->settings->set(['two_factor_enabled' => '1']);
        $user = User::factory()->superuser()->create([
            'two_factor_enrolled' => '0',
            'two_factor_optin' => '1',
        ]);

        Passport::actingAs($user);

        $this->getJson(route('api.users.me'))
            ->assertForbidden()
            ->assertJson(['status' => 'error']);
    }

    public function test_optional_two_factor_lets_optin_enrolled_users_through()
    {
        $this->settings->set(['two_factor_enabled' => '1']);
        $user = User::factory()->superuser()->create([
            'two_factor_enrolled' => '1',
            'two_factor_optin' => '1',
            'two_factor_secret' => 'TESTSECRET',
        ]);

        Passport::actingAs($user);

        $this->getJson(route('api.users.me'))->assertOk();
    }

    /**
     * The core regression pin: an unenrolled user's PAT is blocked when the
     * install is set to require 2FA for everyone. This closes the reported
     * vulnerability where two_factor_enabled=2 only affected the web group
     * and left already-issued PATs fully usable.
     */
    public function test_required_two_factor_blocks_unenrolled_pat()
    {
        $this->settings->set(['two_factor_enabled' => '2']);
        $user = User::factory()->superuser()->create([
            'two_factor_enrolled' => '0',
            'two_factor_optin' => '0',
        ]);

        Passport::actingAs($user);

        $this->getJson(route('api.users.me'))
            ->assertForbidden()
            ->assertJson(['status' => 'error']);
    }

    public function test_required_two_factor_lets_enrolled_pat_through()
    {
        $this->settings->set(['two_factor_enabled' => '2']);
        $user = User::factory()->superuser()->create([
            'two_factor_enrolled' => '1',
            'two_factor_optin' => '1',
            'two_factor_secret' => 'TESTSECRET',
        ]);

        Passport::actingAs($user);

        $this->getJson(route('api.users.me'))->assertOk();
    }

    /**
     * Required mode blocks even opted-in-but-unenrolled users, since "opted
     * in" alone doesn't mean the account can accept a code. Mirrors the
     * required-mode branch that ignores the optin flag entirely.
     */
    public function test_required_two_factor_blocks_optin_but_unenrolled_pat()
    {
        $this->settings->set(['two_factor_enabled' => '2']);
        $user = User::factory()->superuser()->create([
            'two_factor_enrolled' => '0',
            'two_factor_optin' => '1',
        ]);

        Passport::actingAs($user);

        $this->getJson(route('api.users.me'))->assertForbidden();
    }

    /**
     * The middleware must not emit its 2FA-enrollment 403 in place of whatever
     * auth:api does for a missing/bad token; otherwise clients can't tell
     * "unauthenticated" from "authenticated but blocked by policy." We don't
     * pin the exact unauthenticated status code (Laravel's fallback may vary
     * by config), only that our middleware didn't override it.
     */
    public function test_no_token_response_is_not_our_403()
    {
        $this->settings->set(['two_factor_enabled' => '2']);

        $response = $this->getJson(route('api.users.me'));

        $this->assertNotEquals(403, $response->getStatusCode());
    }
}
