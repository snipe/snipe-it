<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

/**
 * Regression for the Passport-personal-access-tokens permission
 * bypass. Passport's default routes at /oauth/personal-access-tokens
 * are auto-registered by its service provider with only web +
 * auth:web middleware, so any user with a valid session cookie could
 * POST and mint a long-lived bearer token even if their self.api
 * permission had been revoked.
 *
 * The fix registers overriding routes at the same URIs in
 * routes/web.php (which loads before Passport's package service
 * provider boots, so FIFO route resolution picks ours) with the
 * `can:self.api` gate added. Authorized users still hit the same
 * PersonalAccessTokenController Passport would have used.
 */
class PassportPersonalAccessTokenGateTest extends TestCase
{
    public function test_user_without_self_api_cannot_create_personal_access_token(): void
    {
        $user = User::factory()->create(); // default: no self.api permission

        $this->actingAs($user)
            ->post('/oauth/personal-access-tokens', [
                'name' => 'bypass-attempt',
                'scopes' => [],
            ])
            ->assertForbidden();
    }

    public function test_user_without_self_api_cannot_list_personal_access_tokens(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/oauth/personal-access-tokens')
            ->assertForbidden();
    }

    public function test_user_without_self_api_cannot_delete_personal_access_token(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete('/oauth/personal-access-tokens/any-token-id')
            ->assertForbidden();
    }

    public function test_unauthenticated_request_is_rejected_by_auth_middleware(): void
    {
        // Baseline: the outer `auth` middleware still fires before
        // the can:self.api gate. Unauthenticated requests get bounced
        // to login, not silently allowed.
        $response = $this->post('/oauth/personal-access-tokens', [
            'name' => 'unauth-attempt',
            'scopes' => [],
        ]);

        $this->assertContains($response->status(), [302, 401, 403], 'Unauthenticated requests must not receive a 200/2xx');
    }

    public function test_superuser_passes_the_self_api_gate(): void
    {
        // Superusers bypass every gate via AuthServiceProvider's
        // Gate::before hook, so they must still be able to reach the
        // controller. The controller itself may fail later in the
        // test env if no Passport personal access client is
        // installed; that's a Passport-setup concern, not the gate's.
        // We only assert the gate lets them through (status != 403).
        $user = User::factory()->superuser()->create();

        $response = $this->actingAs($user)
            ->post('/oauth/personal-access-tokens', [
                'name' => 'authorized-attempt',
                'scopes' => [],
            ]);

        $this->assertNotSame(403, $response->status(), 'Superuser must not be blocked by the self.api gate.');
    }
}
