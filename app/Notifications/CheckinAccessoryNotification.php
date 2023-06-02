<?php

namespace App\Notifications;

use App\Models\Accessory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class CheckinAccessoryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param $params
     */
    public function __construct(Accessory $accessory, $checkedOutTo, User $checkedInby, $note)
    {
        $this->item = $accessory;
        $this->target = $checkedOutTo;
        $this->admin = $checkedInby;
        $this->note = $note;
        $this->settings = Setting::getSettings();
        \Log::debug('Constructor for notification fired');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        \Log::debug('via called');
        $notifyBy = [];

        if (Setting::getSettings()->webhook_endpoint != '') {
            $notifyBy[] = 'slack';
        }

        /**
         * Only send notifications to users that have email addresses
         */
        if ($this->target instanceof User && $this->target->email != '') {
            \Log::debug('The target is a user');

            /**
             * Send an email if the asset requires acceptance,
             * so the user can accept or decline the asset
             */
            if (($this->item->requireAcceptance()) || ($this->item->getEula()) || ($this->item->checkin_email())) {
                $notifyBy[] = 'mail';
            }

            /**
             * Send an email if the asset requires acceptance,
             * so the user can accept or decline the asset
             */
            if ($this->item->requireAcceptance()) {
                \Log::debug('This accessory requires acceptance');
            }

            /**
             * Send an email if the item has a EULA, since the user should always receive it
             */
            if ($this->item->getEula()) {
                \Log::debug('This accessory has a EULA');
            }

            /**
             * Send an email if an email should be sent at checkin/checkout
             */
            if ($this->item->checkin_email()) {
                \Log::debug('This accessory has a checkin_email()');
            }
        }

        \Log::debug('checkin_email on this category is '.$this->item->checkin_email());

        return $notifyBy;
    }

    public function toSlack()
    {
        $target = $this->target;
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;
        $botname = ($this->settings->webhook_botname) ? $this->settings->webhook_botname : 'Snipe-Bot';
        $channel = ($this->settings->webhook_channel) ? $this->settings->webhook_channel : '';

        $fields = [
            'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
            'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
        ];

        return (new SlackMessage)
            ->content(':arrow_down: :keyboard: '.trans('mail.Accessory_Checkin_Notification'))
            ->from($botname)
            ->to($channel)
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
    public function toMail()
    {
        \Log::debug('to email called');

        return (new MailMessage)->markdown('notifications.markdown.checkin-accessory',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
            ])
            ->subject(trans('mail.Accessory_Checkin_Notification'));
    }
}
