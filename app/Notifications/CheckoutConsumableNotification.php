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

class CheckoutConsumableNotification extends Notification
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
        $this->last_checkout = '';
        $this->expected_checkin = '';
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
    public function via($notifiable)
    {
        $notifyBy = [];

        if (Setting::getSettings()->slack_endpoint!='') {
            $notifyBy[] = 'slack';
        }

        // Make sure the target is a user and that its appropriate to send them an email
        if ((($this->target->email!='') && ($this->target_type == 'App\Models\User')) && (($this->item->requireAcceptance() == '1') || ($this->item->getEula())))
        {
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
            ->content(':arrow_up: :paperclip: Consumable Checked Out')
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

        \Log::debug($this->item->getImageUrl());
        $eula =  $this->item->getEula();
        $req_accept = $this->item->requireAcceptance();

        return (new MailMessage)->markdown('notifications.markdown.checkout-consumable',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'log_id'        => $this->note,
                'target'        => $this->target,
                'eula'          => $eula,
                'req_accept'    => $req_accept,
                'accept_url'    =>  url('/').'/account/accept-asset/'.$this->log_id,
            ])
            ->subject(trans('mail.Confirm_consumable_delivery'));

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
