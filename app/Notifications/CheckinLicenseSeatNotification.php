<?php

namespace App\Notifications;

use App\Models\LicenseSeat;
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

class CheckinLicenseSeatNotification extends Notification
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
    public function __construct(LicenseSeat $licenseSeat, $checkedOutTo, User $checkedInBy, $note)
    {
        $this->target = $checkedOutTo;
        $this->item = $licenseSeat->license;
        $this->admin = $checkedInBy;
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
         * Only send checkin notifications to users if the category
         * has the corresponding checkbox checked.
         */
        if ($this->item->checkin_email() && $this->target instanceof User && $this->target->email != '') {
            $notifyBy[] = 'mail';
        }

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

        if ($admin) {
            $fields = [
                'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
                'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
            ];
        } else {
            $fields = [
                'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
                'By' => 'CLI tool',
            ];
        }

        return (new SlackMessage)
            ->content(':arrow_down: :floppy_disk: '.trans('mail.License_Checkin_Notification'))
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
        $target = $this->target;
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;

        return MicrosoftTeamsMessage::create()
            ->to($this->settings->webhook_endpoint)
            ->type('success')
            ->addStartGroupToSection('activityTitle')
            ->title(trans('mail.License_Checkin_Notification'))
            ->addStartGroupToSection('activityText')
            ->fact(htmlspecialchars_decode($item->present()->name), '', 'header')
            ->fact(trans('mail.License_Checkin_Notification')." by ", $admin->present()->fullName() ?: 'CLI tool')
            ->fact(trans('mail.checkedin_from'), $target->present()->fullName())
            ->fact(trans('admin/consumables/general.remaining'), $item->availCount()->count())
            ->fact(trans('mail.notes'), $note ?: '');
    }
    public function toGoogleChat()
    {
        $target = $this->target;
        $item = $this->item;
        $note = $this->note;

        return GoogleChatMessage::create()
            ->to($this->settings->webhook_endpoint)
            ->card(
                Card::create()
                    ->header(
                        '<strong>'.trans('mail.License_Checkin_Notification').'</strong>' ?: '',
                        htmlspecialchars_decode($item->present()->name) ?: '',
                    )
                    ->section(
                        Section::create(
                            KeyValue::create(
                                trans('mail.checkedin_from') ?: '',
                                $target->present()->fullName() ?:  '',
                                trans('admin/consumables/general.remaining').': '.$item->availCount()->count(),
                            )
                                ->onClick(route('licenses.show', $item->id))
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
        return (new MailMessage)->markdown('notifications.markdown.checkin-license',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
            ])
            ->subject(trans('mail.License_Checkin_Notification'));
    }
}
