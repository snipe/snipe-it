<?php
namespace App\Http\Middleware;

use Closure;

class FrameGuard
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
        $response = $next($request);
        if (config('app.allow_iframing') == false) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);
        }
        return $response;

    }
}
