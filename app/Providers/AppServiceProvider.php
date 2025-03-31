<?php

namespace App\Providers;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\User;
use App\Models\Setting;
use App\Models\SnipeSCIMConfig;
use App\Observers\AccessoryObserver;
use App\Observers\AssetObserver;
use App\Observers\UserObserver;
use App\Observers\ComponentObserver;
use App\Observers\ConsumableObserver;
use App\Observers\LicenseObserver;
use App\Observers\SettingObserver;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View; 

/**
 * This service provider handles setting the observers on models
 *
 * PHP version 5.5.9
 * @version    v3.0
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap application services.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        /**
         * This is a workaround for proxies/reverse proxies that don't always pass the proper headers.
         *
         * Here, we check if the APP_URL starts with https://, which we should always honor,
         * regardless of how well the proxy or network is configured.
         *
         * We'll force the https scheme if the APP_URL starts with https://, or if APP_FORCE_TLS is set to true.
         *
         */
        if ((strpos(env('APP_URL'), 'https://') === 0) || (env('APP_FORCE_TLS'))) {
            $url->forceScheme('https');
        }

        // TODO - isn't it somehow 'gauche' to check the environment directly; shouldn't we be using config() somehow?
        if ( ! env('APP_ALLOW_INSECURE_HOSTS')) {  // unless you set APP_ALLOW_INSECURE_HOSTS, you should PROHIBIT forging domain parts of URL via Host: headers
            $url_parts = parse_url(config('app.url'));
            if ($url_parts && array_key_exists('scheme', $url_parts) && array_key_exists('host', $url_parts)) { // check for the *required* parts of a bare-minimum URL
                URL::forceRootUrl(config('app.url'));
            } else {
                Log::error("Your APP_URL in your .env is misconfigured - it is: ".config('app.url').". Many things will work strangely unless you fix it.");
            }
        }

        \Illuminate\Pagination\Paginator::useBootstrap();

        Schema::defaultStringLength(191);
        Asset::observe(AssetObserver::class);
        User::observe(UserObserver::class);
        Accessory::observe(AccessoryObserver::class);
        Component::observe(ComponentObserver::class);
        Consumable::observe(ConsumableObserver::class);
        License::observe(LicenseObserver::class);
        Setting::observe(SettingObserver::class);

        // Share manager view data with the default layout if enabled and user is logged in
        View::composer('layouts.default', function ($view) {
            if (Auth::check()) {
                $settings = Setting::getSettings();
                $user = Auth::user();
                $subordinates = collect(); // Initialize as empty collection
                $selectedUserId = $user->id; // Default to current user

                // Use getAllSubordinates(true) which includes the manager themselves
                if ($settings->manager_view_enabled) {
                     if ($user->isSuperUser()) {
                         // SuperAdmin sees all users
                         $subordinates = User::select('id', 'first_name', 'last_name', 'username')->get();
                     } else {
                         // Regular manager sees their subordinates + self
                         $subordinates = $user->getAllSubordinates(true); // Use the correct method, includes self
                     }

                     // Check if a specific user ID is requested via query parameter
                     if (request()->filled('user_id') && $subordinates->contains('id', request('user_id'))) {
                         $selectedUserId = (int) request('user_id');
                     } elseif (session()->has('manager_view_user_id') && $subordinates->contains('id', session('manager_view_user_id'))) {
                         // Optionally check session if you store the selection there
                         $selectedUserId = (int) session('manager_view_user_id');
                     }

                     // Store the selected ID in session if needed for persistence across requests
                     // session(['manager_view_user_id' => $selectedUserId]);

                }


                // Only pass subordinates if the count is greater than 1
                if ($subordinates->count() > 1) {
                    $view->with('subordinates', $subordinates->sortBy('username')); // Sort for better display
                    $view->with('selectedUserId', $selectedUserId);
                } else {
                    // Pass empty collection if not applicable
                     $view->with('subordinates', collect());
                     $view->with('selectedUserId', $user->id); // Default to self if no subordinates applicable
                }

                // Always pass settings
                $view->with('settings', $settings);

                // RE-ADD TEMPORARY DEBUG LOGGING
                Log::debug('View Composer for layouts.default (After Fixes):');
                Log::debug(' - User ID: ' . ($user->id ?? 'null'));
                Log::debug(' - Is SuperUser: ' . ($user->isSuperUser() ? 'true' : 'false'));
                Log::debug(' - manager_view_enabled: ' . (isset($settings->manager_view_enabled) ? $settings->manager_view_enabled : 'not set'));
                Log::debug(' - subordinates count: ' . ($subordinates->count() ?? 'null'));
                Log::debug(' - selectedUserId: ' . ($selectedUserId ?? 'null'));
                // END TEMPORARY DEBUG LOGGING


            } else {
                 // Pass default/empty values if user is not logged in
                 $view->with('settings', Setting::getSettings()); // Still might need settings for guests
                 $view->with('subordinates', collect());
                 $view->with('selectedUserId', null);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Only load rollbar if there is a rollbar key and the app is in production
        if (($this->app->environment('production')) && (config('logging.channels.rollbar.access_token'))) {
            $this->app->register(\Rollbar\Laravel\RollbarServiceProvider::class);
        }

        $this->app->singleton('ArieTimmerman\Laravel\SCIMServer\SCIMConfig', SnipeSCIMConfig::class); // this overrides the default SCIM configuration with our own
    
    }
}
