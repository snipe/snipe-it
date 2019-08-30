<?php
namespace App\Http\Middleware;

use Closure;

class XssProtectHeader
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
        $mode = '1;mode=block';
        $response = $next($request);
        $response->headers->set('X-XSS-Protection', $mode);
        return $response;
    }
}
