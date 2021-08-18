<?php
namespace App\Providers;


use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Setting;
use App\Observers\AccessoryObserver;
use App\Observers\AssetObserver;
use App\Observers\ComponentObserver;
use App\Observers\ConsumableObserver;
use App\Observers\LicenseObserver;
use App\Observers\SettingObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

/**
 * This service provider handles setting the observers on models
 *
 * PHP version 5.5.9
 * @version    v3.0
 */

class AppServiceProvider extends ServiceProvider
{
    /**
     * Custom email array validation
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('APP_FORCE_TLS')) {
            if (strpos(env('APP_URL'), 'https') === 0) {
                $url->forceScheme('https');
            } else {
                \Log::warning("'APP_FORCE_TLS' is set to true, but 'APP_URL' does not start with 'https://'. Will not force TLS on connections.");
            }
        }
        Schema::defaultStringLength(191);
        Asset::observe(AssetObserver::class);
        Accessory::observe(AccessoryObserver::class);
        Component::observe(ComponentObserver::class);
        Consumable::observe(ConsumableObserver::class);
        License::observe(LicenseObserver::class);
        Setting::observe(SettingObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if (($this->app->environment('production'))  && (config('logging.channels.rollbar.access_token'))) {
            $this->app->register(\Rollbar\Laravel\RollbarServiceProvider::class);
        }

    }
}
