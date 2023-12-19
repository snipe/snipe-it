<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use \App\Helpers\Helper;

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

        // Default app settings from config
        $language = config('app.locale');

        if ($settings = Setting::getSettings()) {

            // User's preference
            if (($request->user()) && ($request->user()->locale)) {
                $language = $request->user()->locale;

            // App setting preference
            } elseif ($settings->locale != '') {
                $language = $settings->locale;
            }

        }

        \App::setLocale(Helper::mapLegacyLocale($language));
        return $next($request);
    }
}
