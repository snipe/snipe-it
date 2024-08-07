<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\Card;
use NotificationChannels\GoogleChat\Enums\Icon;
use NotificationChannels\GoogleChat\Enums\ImageStyle;
use NotificationChannels\GoogleChat\GoogleChatChannel;
use NotificationChannels\GoogleChat\GoogleChatMessage;
use NotificationChannels\GoogleChat\Section;
use NotificationChannels\GoogleChat\Widgets\KeyValue;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use Illuminate\Support\Facades\Log;
class CheckoutAssetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param $params
     */
    public function __construct(Asset $asset, $checkedOutTo, User $checkedOutBy, $acceptance, $note)
    {
        $this->item = $asset;
        $this->admin = $checkedOutBy;
        $this->note = $note;
        $this->target = $checkedOutTo;
        $this->acceptance = $acceptance;

        $this->settings = Setting::getSettings();

        $this->last_checkout = '';
        $this->expected_checkin = '';

        if ($this->item->last_checkout) {
            $this->last_checkout = Helper::getFormattedDateObject($this->item->last_checkout, 'date',
                false);
        }

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
        $notifyBy = [];
        if (Setting::getSettings()->webhook_selected == 'google' && Setting::getSettings()->webhook_endpoint) {

            $notifyBy[] = GoogleChatChannel::class;
        }

        if (Setting::getSettings()->webhook_selected == 'microsoft' && Setting::getSettings()->webhook_endpoint) {

            $notifyBy[] = MicrosoftTeamsChannel::class;
        }


        if (Setting::getSettings()->webhook_selected == 'slack' || Setting::getSettings()->webhook_selected == 'general' ) {

            Log::debug('use webhook');
            $notifyBy[] = 'slack';
        }

        /**
         * Only send notifications to users that have email addresses
         */
        if ($this->target instanceof User && $this->target->email != '') {

            /**
             * Send an email if the asset requires acceptance,
             * so the user can accept or decline the asset
             */
            if ($this->item->requireAcceptance()) {
                $notifyBy[1] = 'mail';
            }

            /**
             * Send an email if the item has a EULA, since the user should always receive it
             */
            if ($this->item->getEula()) {
                $notifyBy[1] = 'mail';
            }

            /**
             * Send an email if an email should be sent at checkin/checkout
             */
            if ($this->item->checkin_email()) {
                $notifyBy[1] = 'mail';
            }
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

        if (($this->expected_checkin) && ($this->expected_checkin != '')) {
            $fields['Expected Checkin'] = $this->expected_checkin;
        }

        return (new SlackMessage)
            ->content(':arrow_up: :computer: '.trans('mail.Asset_Checkout_Notification'))
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
            ->title(trans('mail.Asset_Checkout_Notification'))
            ->addStartGroupToSection('activityText')
            ->fact(trans('mail.assigned_to'), $target->present()->name)
            ->fact(htmlspecialchars_decode($item->present()->name), '', 'activityText')
            ->fact(trans('mail.Asset_Checkout_Notification') . " by ", $admin->present()->fullName())
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
                        '<strong>'.trans('mail.Asset_Checkout_Notification').'</strong>' ?: '',
                        htmlspecialchars_decode($item->present()->name) ?: '',
                    )
                    ->section(
                        Section::create(
                            KeyValue::create(
                                trans('mail.assigned_to') ?: '',
                                $target->present()->name ?: '',
                                $note ?: '',
                            )
                                ->onClick(route('users.show', $target->id))
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
        $eula = method_exists($this->item, 'getEula') ? $this->item->getEula() : '';
        $req_accept = method_exists($this->item, 'requireAcceptance') ? $this->item->requireAcceptance() : 0;

        $fields = [];

        // Check if the item has custom fields associated with it
        if (($this->item->model) && ($this->item->model->fieldset)) {
            $fields = $this->item->model->fieldset->fields;
        }

        $accept_url = is_null($this->acceptance) ? null : route('account.accept.item', $this->acceptance);

        $message = (new MailMessage)->markdown('notifications.markdown.checkout-asset',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'status'        => $this->item->assetstatus?->name,
                'note'          => $this->note,
                'target'        => $this->target,
                'fields'        => $fields,
                'eula'          => $eula,
                'req_accept'    => $req_accept,
                'accept_url'    => $accept_url,
                'last_checkout' => $this->last_checkout,
                'expected_checkin'  => $this->expected_checkin,
            ])
            ->subject(trans('mail.Confirm_asset_delivery'));

        return $message;
    }
}
