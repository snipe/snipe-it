<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckForDebug
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('debug_in_production', false);

        if (((Auth::check() && (Auth::user()->isSuperUser()))) && (app()->environment()=='production') && (config('app.warn_debug')===true) && (config('app.debug')===true)) {
            view()->share('debug_in_production', true);
        }

        return $next($request);
    }
}
