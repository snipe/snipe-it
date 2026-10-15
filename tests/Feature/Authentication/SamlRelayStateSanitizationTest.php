<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Tests\TestCase;

/**
 * SamlController::acs() writes the RelayState POST parameter into
 * session()['url.intended']. RelayState is attacker-controllable via a
 * hostile IdP or a crafted SAML POST binding, and several post-auth
 * redirect sites (LoginController::authenticated, RedirectIfAuthenticated,
 * DashboardController) call redirect()->intended() directly, bypassing
 * Helper::getRedirectOption's host-validation guard. So RelayState must
 * be sanitized at write time.
 *
 * The sanitize step runs before Saml::getAuth(), so these tests exercise
 * it even without a fully configured IdP — the endpoint still 500s on
 * the missing SAML config after the write, which is fine for what we're
 * asserting on.
 */
class SamlRelayStateSanitizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // CheckForSetup middleware redirects to /setup when there are no
        // users. Creating one lets acs actually run.
        User::factory()->create();
    }

    public function test_offsite_relaystate_is_not_written_to_intended_url()
    {
        session()->forget('url.intended');

        $this->post(route('saml.acs'), [
            'RelayState' => 'https://evil.example.com/steal-session',
            'SAMLResponse' => 'invalid',
        ]);

        $this->assertNull(session('url.intended'), 'Off-site RelayState must not become url.intended');
    }

    public function test_javascript_scheme_relaystate_is_not_written_to_intended_url()
    {
        session()->forget('url.intended');

        $this->post(route('saml.acs'), [
            'RelayState' => 'javascript:alert(document.cookie)',
            'SAMLResponse' => 'invalid',
        ]);

        $this->assertNull(session('url.intended'));
    }

    public function test_scheme_relative_offsite_relaystate_is_not_written_to_intended_url()
    {
        session()->forget('url.intended');

        $this->post(route('saml.acs'), [
            'RelayState' => '//evil.example.com/steal-session',
            'SAMLResponse' => 'invalid',
        ]);

        $this->assertNull(session('url.intended'));
    }

    public function test_same_origin_relaystate_is_preserved()
    {
        $safeRelay = config('app.url').'/hardware?status=1';

        $this->post(route('saml.acs'), [
            'RelayState' => $safeRelay,
            'SAMLResponse' => 'invalid',
        ]);

        $this->assertSame($safeRelay, session('url.intended'));
    }

    public function test_crlf_in_relaystate_is_stripped()
    {
        $poisoned = config('app.url')."/hardware\r\nSet-Cookie: attacker=1";

        $this->post(route('saml.acs'), [
            'RelayState' => $poisoned,
            'SAMLResponse' => 'invalid',
        ]);

        // CR/LF stripped so this can't split the HTTP response into a
        // header-injection primitive. Remaining text is harmless once
        // the line breaks are gone.
        $stored = session('url.intended');
        $this->assertNotNull($stored);
        $this->assertStringNotContainsString("\r", $stored);
        $this->assertStringNotContainsString("\n", $stored);
    }
}
