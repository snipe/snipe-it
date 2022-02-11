<?php

namespace App\Notifications;

use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
//use Illuminate\Notifications\Messages\SlackMessage;
//use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
//use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;

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
        return NotificationIntegrations::notifyByChannels($this->item, $this->target);
   
    }

    public function toSlack()
    {
        return NotificationIntegrations::slackMessageBuilder($this->item, $this->target, $this->admin, "in", $this->note, $this->expected_checkin, $this->settings->slack_botname);
            
    }

    public function toMicrosoftTeams($notifiable)
    {
        return NotificationIntegrations::msteamsMessageBuilder($this->item, $this->target, $this->admin, "in", $this->note, $this->expected_checkin);

    }

    
    public function toWebhook($notifiable)
    {
        return NotificationIntegrations::webhookMessageBuilder($this->item, $this->target, $this->admin, "in", $this->note, $this->expected_checkin,$this->settings->slack_botname);

        /*
         $expectedCheckin = 'None';
            $target = $this->target;
            $admin = $this->admin;
            $item = $this->item;
            $note = $this->note ?: 'No note provided.';

        return WebhookMessage::create()
        ->data([
                'content' => ':arrow_down: :computer:  **Asset Checked In: ** ['. $item->present()->fullName() .']('.$item->present()->viewUrl().')
            *From:* ['.$target->present()->fullName().']('.$target->present()->viewUrl().')
            *Status:* '.$item->assetstatus->name.'
            *Note*: '.$note.'
            [View in Browser]('.$target->present()->viewUrl().')',
            
        ])
        ->header('Content-Type', 'application/json');
        */
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        $fields = [];

        // Check if the item has custom fields associated with it
        if (($this->item->model) && ($this->item->model->fieldset)) {
            $fields = $this->item->model->fieldset->fields;
        }

        $message = (new MailMessage)->markdown('notifications.markdown.checkin-asset',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
                'fields'        => $fields,
                'expected_checkin'  => $this->expected_checkin,
            ])
            ->subject(trans('mail.Asset_Checkin_Notification'));

        return $message;
    }
}
