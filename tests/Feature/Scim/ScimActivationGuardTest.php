<?php

namespace Tests\Feature\Scim;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Regression coverage for the SCIM middleware gap reported against the
 * fix for CVE-2026-86762. That fix added `CheckUserIsActivated` to the
 * regular `api` middleware group, but the SCIM 2.0 routes
 * (`routes/scim.php`) are registered with their own middleware chain
 * and were not updated at the time. A deactivated superadmin's PAT
 * continued to work against SCIM endpoints, and
 * `PATCH /scim/v2/Users/{id}` with `active: true` would silently
 * restore the deactivated account.
 *
 * Reported by (among others) catAnie, manus-pi, manus-use, rajivraj.
 */
class ScimActivationGuardTest extends TestCase
{
    public function test_deactivated_user_cannot_read_scim_users_endpoint(): void
    {
        $user = User::factory()->superuser()->create(['activated' => 0]);
        Passport::actingAs($user);

        $this->getJson('/scim/v2/Users/'.$user->id)
            ->assertStatus(401);
    }

    public function test_deactivated_user_cannot_patch_their_own_active_flag_back_to_true(): void
    {
        // The specific exploit shape: deactivated superadmin uses their
        // PAT to flip `active: true` on their own SCIM user record,
        // reactivating themselves and defeating offboarding.
        $user = User::factory()->superuser()->create(['activated' => 0]);
        Passport::actingAs($user);

        $this->patchJson('/scim/v2/Users/'.$user->id, [
            'schemas' => ['urn:ietf:params:scim:api:messages:2.0:PatchOp'],
            'Operations' => [
                ['op' => 'replace', 'path' => 'active', 'value' => true],
            ],
        ])->assertStatus(401);

        $this->assertSame(0, (int) $user->fresh()->activated, 'Deactivated user must not be able to re-activate themselves via SCIM.');
    }

    public function test_deactivated_user_cannot_read_scim_me_endpoint(): void
    {
        $user = User::factory()->superuser()->create(['activated' => 0]);
        Passport::actingAs($user);

        $this->getJson('/scim/v2/Me')
            ->assertStatus(401);
    }

    public function test_activated_superadmin_still_passes_the_scim_guard(): void
    {
        // Baseline: the activation gate must not break legitimate SCIM
        // usage. An activated superadmin's PAT should continue to work
        // against SCIM endpoints exactly as before.
        $user = User::factory()->superuser()->create(['activated' => 1]);
        Passport::actingAs($user);

        $this->getJson('/scim/v2/Users/'.$user->id)
            ->assertOk();
    }
}
