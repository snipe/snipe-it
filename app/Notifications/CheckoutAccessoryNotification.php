<?php

namespace App\Notifications;

use App\Models\Accessory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\SlackWebhookChannel;
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

class CheckoutAccessoryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Accessory $accessory, $checkedOutTo, User $checkedOutBy, $acceptance, $note)
    {
        $this->item = $accessory;
        $this->admin = $checkedOutBy;
        $this->note = $note;
        $this->checkout_qty = $accessory->checkout_qty;
        $this->target = $checkedOutTo;
        $this->acceptance = $acceptance;
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
            $notifyBy[] = SlackWebhookChannel::class;
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

        $fields = [
            'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
            'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
        ];

        return (new SlackMessage)
            ->content(':arrow_up: :keyboard: Accessory Checked Out')
            ->from($botname)
            ->to($channel)
            ->attachment(function ($attachment) use ($item, $note, $admin, $fields) {
                $attachment->title(htmlspecialchars_decode($this->checkout_qty.' x '.$item->present()->name), $item->present()->viewUrl())
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
                ->title(trans('mail.Accessory_Checkout_Notification'))
                ->addStartGroupToSection('activityText')
                ->fact(htmlspecialchars_decode($item->present()->name), '', 'activityTitle')
                ->fact(trans('mail.assigned_to'), $target->present()->name)
                ->fact(trans('general.qty'), $this->checkout_qty)
                ->fact(trans('mail.checkedout_from'), $item->location->name ? $item->location->name : '')
                ->fact(trans('mail.Accessory_Checkout_Notification') . " by ", $admin->present()->fullName())
                ->fact(trans('admin/consumables/general.remaining'), $item->numRemaining())
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
                        '<strong>'.trans('mail.Accessory_Checkout_Notification').'</strong>' ?: '',
                        htmlspecialchars_decode($item->present()->name) ?: '',
                    )
                    ->section(
                        Section::create(
                            KeyValue::create(
                                trans('mail.assigned_to') ?: '',
                                $target->present()->name ?: '',
                                trans('admin/consumables/general.remaining').": ". $item->numRemaining(),
                            )
                                ->onClick(route('users.show', $target->id))
                        )
                    )
            );

    }

}
