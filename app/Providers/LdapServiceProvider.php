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
        
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LdapAd::class, LdapAd::class);
    }
}
