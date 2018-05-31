<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\SnipeModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $notifyBy = [];
        $item = $this->params['item'];

        $notifyBy[]='mail';
        return $notifyBy;
    }

    public function toSlack($notifiable)
    {

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $asset
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($params)
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
