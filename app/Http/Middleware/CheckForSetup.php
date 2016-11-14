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
<<<<<<< HEAD
            if (!$request->is('setup*')) {
=======
            if (!($request->is('setup*')) && !($request->is('.env'))) {
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
                return redirect(config('app.url').'/setup')->with('Request', $request);
            }

            return $next($request);

        }


    }
}
