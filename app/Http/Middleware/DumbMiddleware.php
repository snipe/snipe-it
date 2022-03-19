<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DumbMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        \Log::info("DUMB MIDDLEWARE IS HANDLING REQUEST");
        return $next($request);
        \Log::info("DUMB MIDDLEWARE has _handled_ request...");
    }
}
