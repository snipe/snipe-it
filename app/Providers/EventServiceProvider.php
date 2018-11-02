<?php

namespace App\Providers;

use App\Models\Setting;
use App\Events\SettingSaved;
use App\Listeners\LogListener;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use App\Listeners\CheckoutableListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

            'Illuminate\Auth\Events\Login' => [
                'App\Listeners\LogSuccessfulLogin',
            ],

            'Illuminate\Auth\Events\Failed' => [
                'App\Listeners\LogFailedLogin',
            ],
        ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        LogListener::class,
        CheckoutableListener::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        /**
         * Clear the LDAP settings cache when the settings model is saved
         */
        Event::listen(SettingSaved::class, function () {
            Cache::forget(Setting::APP_SETTINGS_KEY);
            Cache::forget(Setting::SETUP_CHECK_KEY);
        });
    }
}
