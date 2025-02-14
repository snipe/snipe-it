<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\SlackWebhookChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use NotificationChannels\GoogleChat\Card;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\Widgets\KeyValue;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use Illuminate\Support\Facades\Log;
class CheckinAssetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param $params
     */
    public function __construct(Asset $asset, $checkedOutTo, User $checkedInBy, $note)
    {
        $this->target = $checkedOutTo;
        $this->item = $asset;
        $this->admin = $checkedInBy;
        $this->note = $note;

        $this->settings = Setting::getSettings();
        $this->expected_checkin = '';

        if ($this->item->expected_checkin) {
            $this->expected_checkin = Helper::getFormattedDateObject($this->item->expected_checkin, 'date',
                false);
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        if (Setting::getSettings()->webhook_selected == 'google' && Setting::getSettings()->webhook_endpoint) {

            $notifyBy[] = GoogleChatChannel::class;
        }

        if (Setting::getSettings()->webhook_selected == 'microsoft' && Setting::getSettings()->webhook_endpoint) {

            $notifyBy[] = MicrosoftTeamsChannel::class;
        }
        if (Setting::getSettings()->webhook_selected == 'slack' || Setting::getSettings()->webhook_selected == 'general' ) {
            Log::debug('use webhook');
            $notifyBy[] = SlackWebhookChannel::class;
        }

        return $notifyBy;
    }

    public function toSlack()
    {
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;
        $botname = ($this->settings->webhook_botname != '') ? $this->settings->webhook_botname : 'Snipe-Bot';
        $channel = ($this->settings->webhook_channel) ? $this->settings->webhook_channel : '';

        $fields = [
            trans('general.administrator') => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
            trans('general.status') => $item->assetstatus?->name,
            trans('general.location') => ($item->location) ? $item->location->name : '',
        ];

        return (new SlackMessage)
            ->content(':arrow_down: :computer: '.trans('mail.Asset_Checkin_Notification'))
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

        if(!Str::contains(Setting::getSettings()->webhook_endpoint, 'workflows')) {
            return MicrosoftTeamsMessage::create()
                ->to($this->settings->webhook_endpoint)
                ->type('success')
                ->title(trans('mail.Asset_Checkin_Notification'))
                ->addStartGroupToSection('activityText')
                ->fact(htmlspecialchars_decode($item->present()->name), '', 'activityText')
                ->fact(trans('mail.checked_into'), ($item->location) ? $item->location->name : '')
                ->fact(trans('mail.Asset_Checkin_Notification') . " by ", $admin->present()->fullName())
                ->fact(trans('admin/hardware/form.status'), $item->assetstatus?->name)
                ->fact(trans('mail.notes'), $note ?: '');
        }


        $message = trans('mail.Asset_Checkin_Notification');
        $details = [
            trans('mail.asset') => htmlspecialchars_decode($item->present()->name),
            trans('mail.checked_into') => ($item->location) ? $item->location->name : '',
            trans('mail.Asset_Checkin_Notification')." by " => $admin->present()->fullName(),
            trans('admin/hardware/form.status') => $item->assetstatus?->name,
            trans('mail.notes') => $note ?: '',
        ];

        return  array($message, $details);
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
                        '<strong>'.trans('mail.Asset_Checkin_Notification').'</strong>' ?: '',
                        htmlspecialchars_decode($item->present()->name) ?: '',
                    )
                    ->section(
                        Section::create(
                            KeyValue::create(
                                trans('mail.checked_into') ?: '',
                                ($item->location) ? $item->location->name : '',
                                trans('admin/hardware/form.status').": ".$item->assetstatus?->name,
                            )
                                ->onClick(route('hardware.show', $item->id))
                        )
                    )
            );
    }
}
