<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;

class CheckForSetup
{
    public function handle($request, Closure $next, $guard = null)
    {

        /**
         * This is dumb
         * @todo Check on removing this, not sure if it's still needed
         */
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
            if (! ($request->is('setup*')) && ! ($request->is('.env')) && ! ($request->is('health'))) {
                return redirect(url('/').'/setup');
            }

            return $next($request);
        }
    }
}
