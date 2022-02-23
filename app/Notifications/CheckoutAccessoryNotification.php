<?php

namespace App\Notifications;

use App\Models\Accessory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\NotificationIntegrations;

class CheckoutAccessoryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Accessory $accessory, $checkedOutTo, User $checkedOutBy, $acceptance, $note)
    {
        $this->expected_checkin = '';
        $this->item = $accessory;
        $this->admin = $checkedOutBy;
        $this->note = $note;
        $this->target = $checkedOutTo;
        $this->acceptance = $acceptance;

        $this->settings = Setting::getSettings();
    }

    /**
     * Get the notification's delivery channels from NotificationIntegrations class.
     * 
     *
     * @return array
     */

    public function via()
    {
       
       return NotificationIntegrations::notifyByChannels($this->item, $this->target);
    }


    /****
     * Laravel Notifications Channels uses these to return message.
     * We build messages in NotificationIntegration to keep formatting consistent.
     */

    public function toSlack()
    {
        return NotificationIntegrations::slackMessageBuilder($this->item, $this->target, $this->admin, $this->direction, $this->note, $this->expected_checkin, $this->settings->slack_botname);
    }

    public function toMicrosoftTeams($notifiable)
    {
       return NotificationIntegrations::msteamsMessageBuilder($this->item, $this->target, $this->admin, $this->direction, $this->note, $this->expected_checkin);
    }

    public function toWebhook($notifiable)
    {
        return NotificationIntegrations::webhookMessageBuilder($this->item, $this->target, $this->admin, $this->direction, $this->note, $this->expected_checkin, $this->settings->slack_botname);
    }

    public function toDiscord($notifiable)
    {
        return NotificationIntegrations::slackMessageBuilder($this->item, $this->target, $this->admin, $this->direction, $this->note, $this->expected_checkin, $this->settings->discord_botname);
     }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        \Log::debug($this->item->getImageUrl());
        $eula = $this->item->getEula();
        $req_accept = $this->item->requireAcceptance();

        $accept_url = is_null($this->acceptance) ? null : route('account.accept.item', $this->acceptance);

        return (new MailMessage)->markdown('notifications.markdown.checkout-accessory',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
                'eula'          => $eula,
                'req_accept'    => $req_accept,
                'accept_url'    => $accept_url,
            ])
            ->subject(trans('mail.Confirm_accessory_delivery'));
    }
}
