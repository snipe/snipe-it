<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;
use Schema;
use App\Models\User;

class CheckForSetup
{
    public function handle($request, Closure $next, $guard = null)
    {

        try {

            $users_table_exists = Schema::hasTable('users');
            $settings_table_exists = Schema::hasTable('settings');

            if ($users_table_exists && $settings_table_exists) {
                $usercount = User::withTrashed()->count();
                if (($usercount > 0) && (Route::is('setup*'))) {
                    return redirect(config('app.url'));
                } else {
                    return $next($request);
                }
            } else {
                return $next($request);
            }


        } catch (\Exception $e) {
            return $next($request);
        }





    }
}
