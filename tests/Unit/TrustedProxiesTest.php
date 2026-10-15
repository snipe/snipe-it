<?php

namespace Tests\Unit;

use App\Http\Middleware\TrustProxies;
use Illuminate\Http\Request;
use Tests\TestCase;

class TrustedProxiesTest extends TestCase
{
    protected function tearDown(): void
    {
        // These are process-wide statics on the Symfony/Illuminate classes, not
        // part of the Laravel application container, so they survive the
        // per-test application reset and must be cleared manually.
        Request::setTrustedProxies([], -1);
        TrustProxies::flushState();

        parent::tearDown();
    }

    private function makeSpoofedRequest(string $remoteAddr, string $forwardedFor): Request
    {
        $request = Request::create('http://example.com/test', 'GET', [], [], [], [
            'REMOTE_ADDR' => $remoteAddr,
        ]);
        $request->headers->set('X-Forwarded-For', $forwardedFor);

        return $request;
    }

    public function test_untrusted_direct_client_cannot_spoof_its_ip_by_default()
    {
        config([
            'trustedproxy.proxies' => '',
            'trustedproxy.headers' => '',
        ]);

        $request = $this->makeSpoofedRequest('203.0.113.9', '1.1.1.1');

        $resolvedIp = (new TrustProxies())->handle($request, fn ($req) => $req->ip());

        $this->assertSame('203.0.113.9', $resolvedIp);
    }

    public function test_a_configured_trusted_proxy_can_report_the_real_client_ip()
    {
        config([
            'trustedproxy.proxies' => '10.0.0.5',
            'trustedproxy.headers' => 'HEADER_X_FORWARDED_FOR',
        ]);

        $request = $this->makeSpoofedRequest('10.0.0.5', '203.0.113.42');

        $resolvedIp = (new TrustProxies())->handle($request, fn ($req) => $req->ip());

        $this->assertSame('203.0.113.42', $resolvedIp);
    }

    public function test_an_untrusted_client_cannot_spoof_its_ip_by_impersonating_a_trusted_proxy()
    {
        config([
            'trustedproxy.proxies' => '10.0.0.5',
            'trustedproxy.headers' => 'HEADER_X_FORWARDED_FOR',
        ]);

        $request = $this->makeSpoofedRequest('203.0.113.9', '1.1.1.1');

        $resolvedIp = (new TrustProxies())->handle($request, fn ($req) => $req->ip());

        $this->assertSame('203.0.113.9', $resolvedIp);
    }

    public function test_an_invalid_header_name_in_config_is_ignored_without_breaking_valid_ones()
    {
        config([
            'trustedproxy.proxies' => '10.0.0.5',
            'trustedproxy.headers' => 'NOT_A_REAL_HEADER,HEADER_X_FORWARDED_FOR',
        ]);

        $request = $this->makeSpoofedRequest('10.0.0.5', '203.0.113.42');

        $resolvedIp = (new TrustProxies())->handle($request, fn ($req) => $req->ip());

        $this->assertSame('203.0.113.42', $resolvedIp);
    }

    public function test_a_trusted_proxy_cannot_forward_headers_when_no_headers_are_configured()
    {
        config([
            'trustedproxy.proxies' => '10.0.0.5',
            'trustedproxy.headers' => '',
        ]);

        // The request genuinely comes from the trusted proxy, but since
        // APP_TRUSTED_HEADERS is unset, X-Forwarded-For must still be
        // ignored - it must NOT fall back to trusting the framework's
        // default header set.
        $request = $this->makeSpoofedRequest('10.0.0.5', '203.0.113.42');

        $resolvedIp = (new TrustProxies())->handle($request, fn ($req) => $req->ip());

        $this->assertSame('10.0.0.5', $resolvedIp);
    }

    public function test_a_trusted_proxy_cannot_forward_headers_when_every_configured_header_is_invalid()
    {
        config([
            'trustedproxy.proxies' => '10.0.0.5',
            'trustedproxy.headers' => 'NOT_A_REAL_HEADER,ALSO_NOT_REAL',
        ]);

        $request = $this->makeSpoofedRequest('10.0.0.5', '203.0.113.42');

        $resolvedIp = (new TrustProxies())->handle($request, fn ($req) => $req->ip());

        $this->assertSame('10.0.0.5', $resolvedIp);
    }
}
