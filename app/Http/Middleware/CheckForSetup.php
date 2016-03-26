<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;
use App\Models\User;

class CheckForSetup
{
    public function handle($request, Closure $next, $guard = null)
    {

        try {
            $usercount = User::withTrashed()->count();
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
