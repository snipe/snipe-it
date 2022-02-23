<?php

namespace App\Notifications;

use App\Models\LicenseSeat;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\NotificationIntegrations;

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
        $this->direction = "in";
        $this->expected_checkin = '';
        $this->target = $checkedOutTo;
        $this->item = $licenseSeat->license;
        $this->admin = $checkedInBy;
        $this->note = $note;
        $this->settings = Setting::getSettings();
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
