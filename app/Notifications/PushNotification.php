<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class HelloNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Welcome to Snipe-IT',
            'body' => 'to Array, This seems nice',
            'action_url' => 'https://snipe-it.test/account/profile',
            'created' => Carbon::now()->toIso8601String(),
        ];
    }

    /**
     * Get the web push representation of the notification.
     *
     * @param  mixed  $notifiable
     * @param  mixed  $notification
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Welcome to Snipe-IT')
            ->icon('/notification-icon.png')
            ->body('Webpush')
            ->actionurl('View app', 'view_app')
            ->data(['id' => $notification->id]);
    }
    public function toAccept($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('You have new items assigned to you')
            ->icon('/notification-icon.png')
            ->body('Please accept or decline your new items')
            ->actionurl('View app', 'view_app')
            ->data(['id' => $notification->id]);
    }
}