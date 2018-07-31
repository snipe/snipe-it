<?php
namespace App\Providers;


use App\Models\LicenseModel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\AssetObserver;
use App\Observers\LicenseObserver;
use App\Observers\AccessoryObserver;
use App\Observers\ConsumableObserver;
use App\Observers\ComponentObserver;
use App\Models\Asset;
use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\Component;


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
    public function boot()
    {
        Schema::defaultStringLength(191);
        Asset::observe(AssetObserver::class);
        Accessory::observe(AccessoryObserver::class);
        Component::observe(ComponentObserver::class);
        Consumable::observe(ConsumableObserver::class);
        LicenseModel::observe(LicenseObserver::class);


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if (($this->app->environment('production'))  && (config('services.rollbar.access_token'))){
            $this->app->register(\Rollbar\Laravel\RollbarServiceProvider::class);
        }

    }
}
