<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Listeners\SendingCheckInNotificationsListener;
use App\Listeners\SendingCheckOutNotificationsListener;
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
        SendingCheckOutNotificationsListener::class,
        SendingCheckInNotificationsListener::class,
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
