<?php

namespace Tests\Feature\Authentication;

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * LoginController::__construct() stashes the current Referer as session
 * key 'backUrl'. redirectTo() then feeds that value straight into
 * Laravel's post-login Redirector, which does no host validation. Login
 * endpoints are often the loosest on CSRF, so a hostile Referer could
 * turn the post-auth landing page into an off-site phishing hand-off
 * unless we sanitize at write time. redirectTo() also re-sanitizes on
 * read as defense-in-depth against any future writer that skips the
 * gate.
 */
class LoginBackUrlSanitizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // CheckForSetup middleware bounces /login to /setup without a
        // user in the DB. Create one so the constructor actually runs.
        User::factory()->create();
    }

    public function test_same_origin_referer_is_stashed_as_backurl_on_login_form_visit()
    {
        $safeReferer = config('app.url').'/hardware?status_type=Deployed';

        $this->from($safeReferer)
            ->get(route('login'))
            ->assertSessionHas('backUrl', $safeReferer);
    }

    public function test_offsite_referer_is_not_stashed_as_backurl_on_login_form_visit()
    {
        $this->from('https://evil.example.com/phish')
            ->get(route('login'))
            ->assertSessionMissing('backUrl');
    }

    public function test_javascript_scheme_referer_is_not_stashed()
    {
        // URL::previous() falls back to the previous URL or, absent
        // that, session()['_previous']['url']. Seed it directly so we
        // can test what happens if a javascript: URL somehow reaches
        // URL::previous().
        $this->withSession(['_previous' => ['url' => 'javascript:alert(1)']])
            ->get(route('login'))
            ->assertSessionMissing('backUrl');
    }

    public function test_redirect_to_returns_stashed_same_origin_url()
    {
        // Construct first — the constructor writes its own backUrl from
        // URL::previous(). Then override the session slot with the
        // scenario we're actually asserting on.
        $controller = app(LoginController::class);

        $safeReferer = config('app.url').'/hardware?status_type=Deployed';
        Session::put('backUrl', $safeReferer);

        $this->assertSame($safeReferer, $controller->redirectTo());
    }

    public function test_redirect_to_falls_back_when_backurl_is_missing()
    {
        $controller = app(LoginController::class);

        Session::forget('backUrl');

        // Default is $this->redirectTo = '/' (see LoginController).
        $this->assertSame('/', $controller->redirectTo());
    }

    public function test_redirect_to_ignores_poisoned_backurl()
    {
        // Defense-in-depth: if a future writer skips the write-side
        // gate, the read here still keeps the redirect on-domain.
        $controller = app(LoginController::class);

        Session::put('backUrl', 'https://evil.example.com/steal-session');

        $this->assertSame('/', $controller->redirectTo());
    }
}
