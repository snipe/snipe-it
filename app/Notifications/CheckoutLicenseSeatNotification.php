<?php

namespace App\Notifications;

use App\Models\LicenseSeat;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;

class CheckoutLicenseSeatNotification extends Notification
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
    public function __construct(LicenseSeat $licenseSeat, $checkedOutTo, User $checkedOutBy, $acceptance, $note)
    {
        $this->direction = "out";
        $this->item = $licenseSeat->license;
        $this->admin = $checkedOutBy;
        $this->note = $note;
        $this->target = $checkedOutTo;
        $this->acceptance = $acceptance;

        $this->settings = Setting::getSettings();
        $this->expected_checkin = '';


        if ($this->item->last_checkout) {
            $this->last_checkout = \App\Helpers\Helper::getFormattedDateObject(
                $this->item->last_checkout,
                'date',
                false
            );
        }

        if ($this->item->expected_checkin) {
            $this->expected_checkin = \App\Helpers\Helper::getFormattedDateObject(
                $this->item->expected_checkin,
                'date',
                false
            );
        }

    }

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
        $eula = method_exists($this->item, 'getEula') ? $this->item->getEula() : '';
        $req_accept = method_exists($this->item, 'requireAcceptance') ? $this->item->requireAcceptance() : 0;

        $accept_url = is_null($this->acceptance) ? null : route('account.accept.item', $this->acceptance);

        return (new MailMessage)->markdown('notifications.markdown.checkout-license',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
                'eula'          => $eula,
                'req_accept'    => $req_accept,
                'accept_url'    => $accept_url,
            ])
            ->subject(trans('mail.Confirm_license_delivery'));
    }
}
