<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;
use Schema;
use App\Models\User;
use App\Models\Setting;

class CheckForSetup
{
    public function handle($request, Closure $next, $guard = null)
    {

        // This is dumb
        if ($request->is('_debugbar*')) {
            return $next($request);
        }

        if (Setting::setupCompleted()) {

            if ($request->is('setup*')) {
                return redirect(url('/'));
            } else {
                return $next($request);
            }

        } else {
            if (!($request->is('setup*')) && !($request->is('.env'))) {
                return redirect(url('/').'/setup');
            }

            return $next($request);

        }


    }
}
