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

        if (Setting::setupCompleted()) {

            if ($request->is('setup*')) {
                return redirect(config('app.url'));
            } else {
                return $next($request);
            }

        } else {
            if (!$request->is('setup*')) {
                return redirect(config('app.url').'/setup')->with('Request', $request);
            }

            return $next($request);

        }


    }
}
