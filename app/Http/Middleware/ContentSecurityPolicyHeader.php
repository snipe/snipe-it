<?php
namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicyHeader
{
    /**
     * Handle the given request and get the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        if ((config('app.debug')=='true')  || (config('app.enable_csp')!='true')) {
            $response = $next($request);
            return $response;
        }

        $policy[] = "default-src 'self'";
        $policy[] = "style-src 'self' 'unsafe-inline' oss.maxcdn.com";
        $policy[] = "script-src 'self' 'unsafe-inline' oss.mafxcdn.com cdnjs.cloudflare.com'";
        $policy[] = "connect-src 'self'";
        $policy[] = "object-src 'none'";
        $policy[] = "font-src 'self' data:";
        $policy[] = "img-src 'self' data: gravatar.com";
        $policy = join(';', $policy);

        $response = $next($request);
        $response->headers->set('Content-Security-Policy', $policy);
        return $response;
    }
}
