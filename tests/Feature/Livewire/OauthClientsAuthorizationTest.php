<?php

namespace Tests\Feature\Livewire;

use App\Livewire\OauthClients;
use App\Models\User;
use Laravel\Passport\Client;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression coverage for the Livewire snapshot-replay authorization bypass
 * reported by PizzaStev3 (2026-07-31). Route-level middleware on /admin/oauth
 * enforces superuser but a POST /livewire/update with a valid signed snapshot
 * of the oauth-clients component reached the component's methods regardless.
 *
 * Fix: boot() gates the admin section, individual sensitive methods
 * (createClient, deleteAuthorizedApplication, editClient) re-check, and
 * the section property is #[Locked] so a client-side snapshot cannot flip
 * from admin section to user section to slip past boot().
 */
class OauthClientsAuthorizationTest extends TestCase
{
    public function test_superuser_can_mount_the_admin_oauth_clients_section()
    {
        $this->actingAs(User::factory()->superuser()->create());

        Livewire::test(OauthClients::class, ['section' => 'oauth-clients'])
            ->assertStatus(200);
    }

    public function test_non_superuser_cannot_mount_the_admin_oauth_clients_section()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(OauthClients::class, ['section' => 'oauth-clients'])
            ->assertStatus(403);
    }

    public function test_non_superuser_cannot_replay_create_client_via_authorized_applications_section()
    {
        // The section property is Locked so a client can't rewrite it from
        // authorized-applications to oauth-clients to slip past boot().
        // Even if boot() lets them through under a benign section, the
        // per-method superuser check on createClient blocks the mint.
        $this->actingAs(User::factory()->create());

        Livewire::test(OauthClients::class, ['section' => 'authorized-applications'])
            ->set('name', 'attacker-client')
            ->set('redirect', 'http://attacker.test/callback')
            ->call('createClient')
            ->assertStatus(403);

        $this->assertDatabaseMissing('oauth_clients', ['name' => 'attacker-client']);
    }

    public function test_non_superuser_cannot_replay_delete_authorized_application_for_others_tokens()
    {
        $victim = User::factory()->create();
        $client = Client::create([
            'user_id' => $victim->id,
            'name' => 'Victim App',
            'secret' => 'secret',
            'provider' => null,
            'redirect' => 'http://victim.test/callback',
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
        ]);
        $victimTokenId = 'victim-token-'.uniqid();
        \DB::table('oauth_access_tokens')->insert([
            'id' => $victimTokenId,
            'user_id' => $victim->id,
            'client_id' => $client->id,
            'name' => 'victim',
            'scopes' => '[]',
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
            'expires_at' => now()->addYear(),
        ]);

        // Attacker acts under the authorized-applications section (which a
        // non-superuser IS allowed to access, since it's the account/api
        // surface). Replay attempts to revoke the victim's active token.
        $this->actingAs(User::factory()->create());

        Livewire::test(OauthClients::class, ['section' => 'authorized-applications'])
            ->call('deleteAuthorizedApplication', $client->id);

        $this->assertDatabaseHas('oauth_access_tokens', [
            'id' => $victimTokenId,
            'revoked' => false,
        ]);
    }

    public function test_superuser_can_still_revoke_any_authorized_application()
    {
        $victim = User::factory()->create();
        $client = Client::create([
            'user_id' => $victim->id,
            'name' => 'Victim App',
            'secret' => 'secret',
            'provider' => null,
            'redirect' => 'http://victim.test/callback',
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
        ]);
        $victimTokenId = 'victim-token-'.uniqid();
        \DB::table('oauth_access_tokens')->insert([
            'id' => $victimTokenId,
            'user_id' => $victim->id,
            'client_id' => $client->id,
            'name' => 'victim',
            'scopes' => '[]',
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
            'expires_at' => now()->addYear(),
        ]);

        $this->actingAs(User::factory()->superuser()->create());

        Livewire::test(OauthClients::class, ['section' => 'oauth-clients'])
            ->call('deleteAuthorizedApplication', $client->id);

        $this->assertDatabaseHas('oauth_access_tokens', [
            'id' => $victimTokenId,
            'revoked' => true,
        ]);
    }

    public function test_non_superuser_cannot_replay_edit_client_to_read_other_client_details()
    {
        $victim = User::factory()->create();
        $client = Client::create([
            'user_id' => $victim->id,
            'name' => 'Victim App',
            'secret' => 'secret',
            'provider' => null,
            'redirect' => 'http://victim.test/callback',
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false,
        ]);

        $this->actingAs(User::factory()->create());

        $component = Livewire::test(OauthClients::class, ['section' => 'authorized-applications'])
            ->call('editClient', $client->id)
            ->assertStatus(403);

        $this->assertSame('', (string) $component->get('editName'));
        $this->assertSame('', (string) $component->get('editRedirect'));
    }
}
