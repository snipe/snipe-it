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

        if (config('app.locale') != Helper::mapLegacyLocale($language)) {
           \Log::warning('Your current APP_LOCALE in your .env is set to "'.config('app.locale').'" and should be updated to be "'.Helper::mapLegacyLocale($language).'" in '.base_path().'/.env. Translations may display unexpectedly until this is updated.');
        }

        \App::setLocale(Helper::mapLegacyLocale($language));
        return $next($request);
    }
}
