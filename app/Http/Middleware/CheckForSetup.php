<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;

class CheckForSetup
{
    public function handle($request, Closure $next, $guard = null)
    {

        try {
            $usercount = \App\Models\User::withTrashed()->count();
            if (($usercount > 0) && (Route::is('setup*'))) {
                return redirect(config('app.url'));
            } else {
                return $next($request);
            }
        } catch (\Exception $e) {
            return $next($request);
        }





    }
}
