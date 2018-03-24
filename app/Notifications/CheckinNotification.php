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
        $this->item = $params['item'];
        $this->admin = $params['admin'];
        $this->note = '';
        if (array_key_exists('note', $params)) {
            $this->note = $params['note'];
        }
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
        if (class_basename(get_class($item))=='Asset') {
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
        \Log::debug('Checkin slack');

        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;

        $fields = [
            'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',

        ];

        $fields[] = ['Status' => $item->assetstatus->name];


        return (new SlackMessage)
            ->content(':arrow_down: ' . class_basename(get_class($item)) . " Checked In")
            ->attachment(function ($attachment) use ($item, $note, $admin, $fields) {
                $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                    ->fields([
                        trans('general.administrator') => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
                    ])
                    ->content($note);
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
