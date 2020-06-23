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
        $response->headers->set('Feature-Policy', 'self');

        if (config('app.allow_iframing') == false) {
            $response->headers->set('X-Frame-Options', 'DENY');
        }


        // This defaults to false to maintain backwards compatibility
        // people who are not running Snipe-IT over TLS (shame, shame, shame!)
        // Seriously though, please run Snipe-IT over TLS. Let's Encrypt is free.
        // https://letsencrypt.org

        if (config('app.enable_hsts') === true) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // We have to exclude debug mode here because debugbar pulls from a CDN or two
        // and it will break things.
        if ((config('app.debug')!='true')  || (config('app.enable_csp')=='true')) {
            $policy[] = "default-src 'self'";
            $policy[] = "style-src 'self' 'unsafe-inline'";
            $policy[] = "script-src 'self' 'unsafe-inline'";
            $policy[] = "connect-src 'self'";
            $policy[] = "object-src 'none'";
            $policy[] = "font-src 'self' data:";
            $policy[] = "img-src 'self' data: gravatar.com";
            $policy = join(';', $policy);
            $response->headers->set('Content-Security-Policy', $policy);
        }

        return $response;
    }

    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }
}
