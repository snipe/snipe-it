<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

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
     * TODO: add $notifyBy [2] = MicrosoftTeamsChannel::class;
     * 
     *
     * @return array
     */
    public function via()
    {
    
        $notifyBy = [];

        if ((Setting::getSettings()) && (Setting::getSettings()->slack_endpoint != '')) {
            \Log::debug('use slack');
            $notifyBy[] = 'slack';
        }

        if (Setting::getSettings()->msteams_endpoint != '') {
            \Log::debug('use msteams');
            $notifyBy[2] = MicrosoftTeamsChannel::class;
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
        $botname = ($this->settings->slack_botname) ? $this->settings->slack_botname : 'Snipe-Bot';

        $fields = [
            'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
            'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
        ];

        if (($this->expected_checkin) && ($this->expected_checkin != '')) {
            $fields['Expected Checkin'] = $this->expected_checkin;
        }

        return (new SlackMessage)
            ->content(':arrow_up: :computer: Asset Checked Out')
            ->from($botname)
            ->attachment(function ($attachment) use ($item, $note, $admin, $fields) {
                $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                    ->fields($fields)
                    ->content($note);
            });
    }

<<<<<<< HEAD
=======

public function toMicrosoftTeams($notifiable)
{
        $expectedCheckin = 'None';
        $target = $this->target;
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;

        if (($this->expected_checkin) && ($this->expected_checkin != '')) {
            $expectedCheckin = $this->expected_checkin;
        }

    return MicrosoftTeamsMessage::create()
        ->to(Setting::getSettings()->msteams_endpoint)
        ->type('success')
        ->addStartGroupToSection($sectionId = 'action_msteams')
        ->title('&#x2B06;&#x1F4BB; Asset Checked Out: <a href=' . $item->present()->viewUrl() . '>' . $item->present()->fullName() . '</a>', $params = ['section' => 'action_msteams'])
        ->content($note, $params = ['section' => 'action_msteams'])
        ->fact('To','<a href='.$target->present()->viewUrl().'>'.$target->present()->fullName().'</a>', $sectionId = 'action_msteams')
        ->fact('By', '<a href='.$admin->present()->viewUrl().'>'.$admin->present()->fullName().'</a>', $sectionId = 'action_msteams')
        ->fact('Expected Checkin', $expectedCheckin, $sectionId = 'action_msteams')
        ->button('View in Browser', ''.$target->present()->viewUrl().'', $params = ['section' => 'action_msteams']);
}

//<a href='.$item->present()->viewUrl().'>'.$item->present()->name).'</a>

>>>>>>> ec134c091 (undo ad hoc notification in checkoutassetnotification)
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
