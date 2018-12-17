<?php namespace App\Providers;

use App\Services\LdapAd;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('LdapAD', function ($app) {
            return new LdapAd();
        });
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
