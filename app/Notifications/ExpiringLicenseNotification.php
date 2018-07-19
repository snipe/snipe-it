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

class ExpiringLicenseNotification extends Notification
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
    public function __construct($params, $threshold)
    {
        $this->licenses = $params;
        $this->threshold = $threshold;
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

        $message = (new MailMessage)->markdown('notifications.markdown.report-expiring-licenses',
            [
                'licenses'  => $this->licenses,
                'threshold'  => $this->threshold,
            ])
            ->subject(trans('mail.Expiring_Licenses_Report'));

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
