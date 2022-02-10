<?php

namespace App\Notifications;

use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
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
        
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note ?: 'No note provided.';
        $botname = ($this->settings->slack_botname != '') ? $this->settings->slack_botname : 'Snipe-Bot';

        $fields = [
            trans('general.administrator') => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
            trans('general.status') => $item->assetstatus->name,
            trans('general.location') => ($item->location) ? $item->location->name : '',
        ];

        return (new SlackMessage)
            ->content(':arrow_down: :computer: '.trans('mail.Asset_Checkin_Notification'))
            ->from($botname)
            ->attachment(function ($attachment) use ($item, $note, $admin, $fields) {
                $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                    ->fields($fields)
                    ->content($note);
            });
            
    }



    public function toMicrosoftTeams($notifiable)
    {

        return NotificationIntegrations::msteamsMessageBuilder($this->item, $this->target, $this->admin, "in", $this->note, $this->expected_checkin);

/*
        $target = $this->target;
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note ?: 'No note provided.';
        $location = ($item->location) ? $item->location->name : '';

        return MicrosoftTeamsMessage::create()
            ->to(Setting::getSettings()->msteams_endpoint)
            ->type('success')
            ->addStartGroupToSection($sectionId = 'action_msteams')
            ->title('&#x2B07;&#x1F4BB; Asset Checked In: <a href=' . $item->present()->viewUrl() . '>' . $item->present()->fullName() . '</a>', $params = ['section' => 'action_msteams'])
            ->content($note, $params = ['section' => 'action_msteams'])
            ->fact('By', '<a href=' . $admin->present()->viewUrl() . '>' . $admin->present()->fullName() . '</a>', $sectionId = 'action_msteams')
            ->fact('Status', $item->assetstatus->name ,$sectionId = 'action_msteams')
            ->fact('Location', $location, $sectionId = 'action_msteams')
            ->button('View in Browser', '' . $target->present()->viewUrl() . '', $params = ['section' => 'action_msteams']);
    */
        }

    
    public function toWebhook($notifiable)
    {
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
