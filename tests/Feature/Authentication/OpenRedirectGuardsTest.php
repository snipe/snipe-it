<?php

namespace Tests\Feature\Authentication;

use App\Exceptions\Handler;
use App\Models\User;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Pre-auth failure-path open-redirect guards. Four form-POST sinks
 * previously called redirect()->back() with no host validation. All now
 * route url()->previous() through Helper::sameOriginUrl before falling
 * back to a route-named default. A crafted link that paired an off-origin
 * Referer with a form failure (CSRF mismatch, bad date, bad reset token,
 * setup-wizard validation failure) could otherwise steer the 302 Location
 * off-site for a phishing hand-off.
 *
 * The two exception-handler branches (TokenMismatch and InvalidFormat)
 * can't be exercised at the HTTP layer in Laravel's default test env
 * because CSRF is disabled and the exception won't fire. They're
 * invoked directly via Handler::render() instead so the Referer-driven
 * sanitize is still regression-covered.
 */
class OpenRedirectGuardsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // ThrottlesLogins shares a RateLimiter cache across tests
        // in-process, so zero it. Otherwise prior failed-login attempts
        // can push this test past the lockout threshold before asserts.
        Cache::flush();
    }

    public function test_token_mismatch_exception_redirect_uses_sameorigin_guard()
    {
        $handler = app(Handler::class);

        $request = $this->bindRequestWithReferer('/login', 'https://evil.example.net/phish');

        $response = $handler->render($request, new TokenMismatchException);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(config('app.url'), rtrim($response->headers->get('Location'), '/'));
    }

    public function test_token_mismatch_exception_redirect_honors_same_origin_referer()
    {
        $handler = app(Handler::class);
        $safeReferer = config('app.url').'/some/path';

        $request = $this->bindRequestWithReferer('/login', $safeReferer);

        $response = $handler->render($request, new TokenMismatchException);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame($safeReferer, $response->headers->get('Location'));
    }

    public function test_invalid_date_exception_redirect_uses_sameorigin_guard()
    {
        $handler = app(Handler::class);

        $request = $this->bindRequestWithReferer('/anything', 'https://evil.example.net/phish');

        $response = $handler->render($request, new InvalidFormatException('bogus date'));

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(config('app.url'), rtrim($response->headers->get('Location'), '/'));
    }

    /**
     * Construct a POST request with the given Referer and bind it as
     * the container's active request so url()->previous() reads from it.
     * Handler::render() reaches for url()->previous() internally via
     * the global helper, which resolves against the container-bound
     * request rather than any ad-hoc instance.
     */
    private function bindRequestWithReferer(string $path, string $referer): Request
    {
        $request = Request::create(config('app.url').$path, 'POST');
        $request->headers->set('referer', $referer);
        $this->app->instance('request', $request);

        return $request;
    }

    public function test_reset_password_invalid_token_does_not_redirect_to_offsite_referer()
    {
        User::factory()->create(['email' => 'reset-me@example.test', 'username' => 'reset-me']);

        // Flipping the password-reset path to the bad-token branch at
        // ResetPasswordController:131 requires a username + email that
        // match a real user, plus a token that doesn't verify.
        $response = $this->from('https://evil.example.net/phish')
            ->post('/password/reset', [
                'username' => 'reset-me',
                'email' => 'reset-me@example.test',
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
                'token' => 'this-token-is-invalid',
            ]);

        $this->assertNotSame('https://evil.example.net/phish', $response->headers->get('Location'));
    }
}
