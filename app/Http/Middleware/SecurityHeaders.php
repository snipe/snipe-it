<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    // See https://securityheaders.com/
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];

    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders($this->unwantedHeaderList);
        $response = $next($request);
        $response->headers->set('Referrer-Policy', config('app.referrer_policy'));
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        if (config('app.allow_iframing') == false) {
            $response->headers->set('X-Frame-Options', 'DENY');
        }

        $policy[] = "default-src 'self'";
        $policy[] = "style-src 'self' 'unsafe-inline' oss.maxcdn.com";
        $policy[] = "script-src 'self' 'unsafe-inline' 'unsafe-eval' cdnjs.cloudflare.com";
        $policy[] = "connect-src 'self'";
        $policy[] = "object-src 'none'";
        $policy[] = "font-src 'self' data:";
        $policy[] = "img-src 'self' data: gravatar.com";
        $policy = join(';', $policy);
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }

    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }
}
