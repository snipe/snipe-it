<?php

namespace Tests\Feature\Authentication;

use App\Helpers\Helper;
use Tests\TestCase;

/**
 * SAML SLO (single-logout) response path open-redirect guard. When the
 * IdP posts back to /saml/sls, SamlController::sls stashes the RelayState
 * URL as session key saml_slo_redirect_url, and LoginController::logout
 * later emits it via redirect()->away(). Pre-fix a hostile IdP (or an IdP
 * that reflects an attacker-supplied RelayState) could land the SLO
 * response Location on an off-origin host immediately after the victim's
 * logout. Fix sanitizes both at write time (SamlController::sls) and at
 * read time (LoginController::logout) using Helper::sameOriginUrl.
 *
 * Full HTTP-level coverage of the away() emission needs the Saml service
 * enabled (processSLO called on a live SAML config), which is not
 * reachable in default test env. The branch is instead covered via the
 * sameOriginUrl primitive itself, which has broad coverage in
 * ExternalUrlTest.
 */
class SamlSloRedirectGuardTest extends TestCase
{
    public function test_sameorigin_url_rejects_offsite_slo_relaystate()
    {
        $this->assertNull(
            Helper::sameOriginUrl('https://attacker.example.net/phish'),
            'A hostile RelayState URL from an IdP must be rejected by the same-origin guard before it reaches the session or the away() emission.'
        );
    }

    public function test_sameorigin_url_accepts_legitimate_slo_relaystate()
    {
        $this->assertNotNull(
            Helper::sameOriginUrl(config('app.url').'/dashboard'),
            'A legitimate same-origin RelayState URL must survive the same-origin guard so an SLO round-trip can return the user to a Snipe-IT page.'
        );
    }
}
