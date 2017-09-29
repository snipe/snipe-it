<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CheckinNotification extends Notification
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
        $item = $this->params['item'];
        if (class_basename(get_class($this->params['item']))=='Asset') {
            if ((method_exists($item, 'requireAcceptance') && ($item->requireAcceptance() == '1'))
                || (method_exists($item, 'getEula') && ($item->getEula()))
            ) {
                $notifyBy[] = 'mail';
            }
        }
        return $notifyBy;
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->success()
            ->content(class_basename(get_class($this->params['item'])) . " Checked In")
            ->attachment(function ($attachment) use ($notifiable) {
                $item = $this->params['item'];
                $admin_user = $this->params['admin'];
                $fields = [
                    'By' => '<'.$admin_user->present()->viewUrl().'|'.$admin_user->present()->fullName().'>',
                ];
                array_key_exists('note', $this->params) && $fields['Notes'] = $this->params['note'];

                $attachment->title($item->name, $item->present()->viewUrl())
                    ->fields($fields);
            });
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\sMessages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
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
