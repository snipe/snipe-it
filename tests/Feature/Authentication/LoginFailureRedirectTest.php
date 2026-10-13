<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * On a failed login POST, LoginController previously called
 * redirect()->back(), which emits a 302 to whatever Referer the browser
 * sent. A crafted link to the login page could land the victim's failed
 * submission on an attacker-controlled host for a phishing hand-off.
 * The fix routes the fallback target through Helper::sameOriginUrl, so
 * only in-origin Referers survive and anything else lands back on the
 * login page (where the withInput + withErrors flash still renders).
 */
class LoginFailureRedirectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // ThrottlesLogins reads/writes RateLimiter cache counters. The
        // array cache driver persists across tests in-process, so a prior
        // test could push this one past the lockout threshold before
        // its first assertion. Zero the counters.
        Cache::flush();
    }

    public function test_validation_failure_does_not_redirect_to_offsite_referer()
    {
        User::factory()->create();

        $this->from('https://evil.example.net/phish')
            ->post('/login', [
                'username' => '',
                'password' => '',
            ])
            ->assertRedirect(route('login'));
    }

    public function test_authentication_failure_does_not_redirect_to_offsite_referer()
    {
        User::factory()->create(['username' => 'legit-user']);

        $this->from('https://evil.example.net/phish')
            ->post('/login', [
                'username' => 'legit-user',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'));
    }

    public function test_validation_failure_honors_same_origin_referer()
    {
        User::factory()->create();

        $safeReferer = config('app.url').'/login';

        $this->from($safeReferer)
            ->post('/login', [
                'username' => '',
                'password' => '',
            ])
            ->assertRedirect($safeReferer);
    }
}
