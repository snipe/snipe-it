<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AuditNotification extends Notification
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
        //
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
        if (Setting::getSettings()->slack_endpoint) {
            $notifyBy[] = 'slack';
        }

        return $notifyBy;
    }

    public function toSlack($notifiable)
    {

        return (new SlackMessage)
            ->success()
            ->content(class_basename(get_class($this->params['item'])) . " Audited")
            ->attachment(function ($attachment) use ($notifiable) {
                $item = $this->params['item'];
                $admin_user = $this->params['admin'];
                $fields = [
                    'By' => '<'.$admin_user->present()->viewUrl().'|'.$admin_user->present()->fullName().'>'
                ];
                array_key_exists('note', $this->params) && $fields['Notes'] = $this->params['note'];
                array_key_exists('location', $this->params) && $fields['Location'] = $this->params['location'];

                $attachment->title($item->present()->name, $item->present()->viewUrl())
                    ->fields($fields);
            });
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

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
