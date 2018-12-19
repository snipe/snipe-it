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
        $this->app->singleton(LdapAD::class, LdapAD::class);
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
