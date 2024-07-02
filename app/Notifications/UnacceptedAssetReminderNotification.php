<?php

namespace App\Notifications;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnacceptedAssetReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($checkout_info, $count)
    {
        $this->count = $count;
        $this->target = $checkout_info['acceptance']->assignedTo;
        $this->acceptance = $checkout_info['acceptance'];

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        $accept_url = route('account.accept');
        $message = (new MailMessage)->markdown('notifications.markdown.asset-reminder',
            [
                'count'          => $this->count,
                'assigned_to'  => $this->target->present()->fullName,
                'link'           => route('account.accept'),
                'accept_url' => $accept_url,
            ])
            ->subject(trans('mail.unaccepted_asset_reminder'));

        return $message;
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
            //
        ];
    }
}
