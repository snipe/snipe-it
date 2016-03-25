<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Route;

class CheckLocale
{
  /**
   * Handle the locale for the user, default to settings otherwise
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */

    public function handle($request, Closure $next, $guard = null)
    {

      // User's preference
        if (($request->user()) && ($request->user()->locale)) {
            \App::setLocale($request->user()->locale);

        // App setting preference
        } elseif ((\App\Models\Setting::getSettings()) &&  (\App\Models\Setting::getSettings()->locale!='')) {
            \App::setLocale(\App\Models\Setting::getSettings()->locale);

        // Default app setting
        } else {
            \App::setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
