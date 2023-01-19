<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;

class CheckLocale
{
    /**
     * Handle the locale for the user, default to settings otherwise.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($settings = Setting::getSettings()) {
            // User's preference
            if (($request->user()) && ($request->user()->locale)) {
                \App::setLocale($request->user()->locale);

            // App setting preference
            } elseif ($settings->locale != '') {
                \App::setLocale($settings->locale);

            // Default app setting
            } else {
                \App::setLocale(config('app.locale'));
            }
        }
        \App::setLocale(config('app.locale'));

        return $next($request);
    }
}
