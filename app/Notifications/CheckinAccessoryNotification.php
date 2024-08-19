<?php

namespace App\Notifications;

use App\Models\Accessory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\Card;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\Widgets\KeyValue;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use Illuminate\Support\Facades\Log;

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
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        $notifyBy = [];
        if (Setting::getSettings()->webhook_selected == 'google' && Setting::getSettings()->webhook_endpoint) {

            $notifyBy[] = GoogleChatChannel::class;
        }

        if (Setting::getSettings()->webhook_selected == 'microsoft' && Setting::getSettings()->webhook_endpoint) {

            $notifyBy[] = MicrosoftTeamsChannel::class;
        }

        if (Setting::getSettings()->webhook_selected == 'slack' || Setting::getSettings()->webhook_selected == 'general' ) {
            $notifyBy[] = 'slack';
        }

        /**
         * Only send notifications to users that have email addresses
         */
        if ($this->target instanceof User && $this->target->email != '') {
            Log::debug('The target is a user');

            if ($this->item->checkin_email()) {
                $notifyBy[] = 'mail';
            }
        }

        Log::debug('checkin_email on this category is '.$this->item->checkin_email());

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
    public function toMicrosoftTeams()
    {
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;

        return MicrosoftTeamsMessage::create()
            ->to($this->settings->webhook_endpoint)
            ->type('success')
            ->addStartGroupToSection('activityTitle')
            ->title(trans('Accessory_Checkin_Notification'))
            ->addStartGroupToSection('activityText')
            ->fact(htmlspecialchars_decode($item->present()->name), '', 'activityTitle')
            ->fact(trans('mail.checked_into'), $item->location->name ? $item->location->name : '')
            ->fact(trans('mail.Accessory_Checkin_Notification')." by ", $admin->present()->fullName())
            ->fact(trans('admin/consumables/general.remaining'), $item->numRemaining())
            ->fact(trans('mail.notes'), $note ?: '');
    }
    public function toGoogleChat()
    {
        $item = $this->item;
        $note = $this->note;

        return GoogleChatMessage::create()
            ->to($this->settings->webhook_endpoint)
            ->card(
                Card::create()
                    ->header(
                        '<strong>'.trans('mail.Accessory_Checkin_Notification').'</strong>' ?: '',
                        htmlspecialchars_decode($item->present()->name) ?: '',
                    )
                    ->section(
                        Section::create(
                            KeyValue::create(
                                trans('mail.checked_into').': '.$item->location->name ? $item->location->name : '',
                                trans('admin/consumables/general.remaining').': '.$item->numRemaining(),
                                trans('admin/hardware/form.notes').": ".$note ?: '',
                            )
                                ->onClick(route('accessories.show', $item->id))
                        )
                    )
            );

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        Log::debug('to email called');

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
