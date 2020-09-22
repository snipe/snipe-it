<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpectedCheckinNotification extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $params;

    /**
     * Create a new notification instance.
     *
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        $notifyBy = [];
        $item = $this->params['item'];

        $notifyBy[]='mail';
        return $notifyBy;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        $formatted_due = Carbon::parse($this->params->expected_checkin)->format('D,  M j, Y');
        return (new MailMessage)
            ->error()
            ->subject('Reminder: '.$this->params->present()->name().' checkin deadline approaching')
            ->line('Hi, '.$this->params->assignedto->first_name.' '.$this->params->assignedto->last_name)
            ->greeting('An asset checked out to you is due to be checked back in on '.$formatted_due.'.')
            ->line('Asset: '.$this->params->present()->name())
            ->line('Serial: '.$this->params->serial)
            ->line('Asset Tag: '.$this->params->asset_tag)
            ->action('View Your Assets', route('view-assets'));
    }

}
