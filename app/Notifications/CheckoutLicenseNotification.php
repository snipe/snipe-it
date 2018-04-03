<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\SnipeModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class CheckoutLicenseNotification extends Notification
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
        $this->target = $params['target'];
        $this->item = $params['item'];
        $this->admin = $params['admin'];
        $this->log_id = $params['log_id'];
        $this->note = '';
        $this->target_type = $params['target_type'];
        $this->settings = $params['settings'];

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
    public function via()
    {
        $notifyBy = [];

        if (Setting::getSettings()->slack_endpoint!='') {
            $notifyBy[] = 'slack';
        }

        if ($this->target_type == \App\Models\User::class) {
            $notifyBy[] = 'mail';
        }



        return $notifyBy;
    }

    public function toSlack($notifiable)
    {

        $target = $this->target;
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;
        $botname = ($this->settings->slack_botname) ? $this->settings->slack_botname : 'Snipe-Bot' ;

        $fields = [
            'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
            'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
        ];

        return (new SlackMessage)
            ->content(':arrow_up: :floppy_disk: License Checked Out')
            ->from($botname)
            ->attachment(function ($attachment) use ($item, $note, $admin, $fields) {
                $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                    ->fields($fields)
                    ->content($note);
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

        return (new MailMessage)->markdown('notifications.markdown.checkout-license',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
            ])
            ->subject(trans('mail.Confirm_license_delivery'));

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
