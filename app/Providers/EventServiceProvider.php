<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
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
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
