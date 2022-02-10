<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
//use NotificationChannels\Discord\DiscordChannel;
//use NotificationChannels\Discord\DiscordMessage;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;

class NotificationIntegrations extends Notification
{ 
    use Queueable;

    public function __construct() {
        return "integration notification initialized";
    }

    public static function notifyByChannels($item, $target)
    {

        //Build array of notification channels.  Typically this will only be one or two channels at a time but this allows for any combination.
        //0= slack, 1=mail, 2=teams, 3=discord/generic Webhook 4=discordBot 5=...
        $notifyBy = [];

        if (Setting::getSettings()) {
        
            if (Setting::getSettings()->slack_endpoint != '') {
                \Log::debug('use slack');
                $notifyBy[] = 'slack';
            }

            if (Setting::getSettings()->msteams_endpoint != '') {
                \Log::debug('use msteams');
                $notifyBy[2] = MicrosoftTeamsChannel::class;
            }
            if (Setting::getSettings()->discord_endpoint != '') {
                \Log::debug('use discord as webhook');
                //TO DO: This should be changed to a maintained DiscordWebhook that supports "embeds"
                $notifyBy[3] = WebhookChannel::class;
            }

        } else {
            \Log::debug('could not retreive settings to determine webhook endpoints.');
        }
        /**
         * Only send notifications to users that have email addresses
         */

        if ($target instanceof User && $target->email != '') {

            /**
             * Send an email if the asset requires acceptance,
             * so the user can accept or decline the asset
             */
            if ($item->requireAcceptance()) {
                $notifyBy[1] = 'mail';
            }

            /**
             * Send an email if the item has a EULA, since the user should always receive it
             */
            if ($item->getEula()) {
                $notifyBy[1] = 'mail';
            }

            /**
             * Send an email if an email should be sent at checkin/checkout
             */
            if ($item->checkin_email()) {
                $notifyBy[1] = 'mail';
            }
        }


        return $notifyBy;
    }

/**
 * Returns the format of message requested
 * $service = msteams, slack, webhook, discordwebhook, discordbot
 * $direction = In or Out
 * $item = what is being checked
 * $type = asset, accessory, license, consumable (out only) = get_class($item)
 * $admin = checked in/out by
 * 
 *       $this->item = $accessory;
 *       $this->target = $checkedOutTo;
 *       $this->admin = $checkedInby;
 *       $this->note = $note;
 *       $this->settings = Setting::getSettings();
 */

    public static function msteamsMessageBuilder($item, $target, $admin, $direction, $note = 'No note provided.', $expectedCheckin = 'none')
    {
          
            $type = class_basename($item);

            $typeicon = [
                "Asset" => "&#x1F4BB;",
                "Accessory" => "&#x2328;",
                "License" => "&#x1F4BE;",
                "Consumable" => "&#x1F4CD;"
            ];
            $directionicon = ($direction =="out" ? "&#x2B06;" : "&#x2B07;");
        
        return MicrosoftTeamsMessage::create()
            ->to(Setting::getSettings()->msteams_endpoint)
            ->type('success')
            ->addStartGroupToSection($sectionId = 'action_msteams')
            ->title(''.$directionicon.''.$typeicon[$type].' '.$type.' Checked '.$direction.': <a href=' . $item->present()->viewUrl() . '>' . $item->present()->fullName() . '</a>', $params = ['section' => 'action_msteams'])
            ->content($note, $params = ['section' => 'action_msteams'])
            ->fact('To','<a href='.$target->present()->viewUrl().'>'.$target->present()->fullName().'</a>', $sectionId = 'action_msteams')
            ->fact('By', '<a href='.$admin->present()->viewUrl().'>'.$admin->present()->fullName().'</a>', $sectionId = 'action_msteams')
            ->fact('Expected Checkin', $expectedCheckin, $sectionId = 'action_msteams')
            ->button('View in Browser', ''.$target->present()->viewUrl().'', $params = ['section' => 'action_msteams']);
    
    }

    public static function slackMessageBuilder($item, $target, $admin, $botname = '', $direction = null, $note = 'No note provided.')
    {
        
            $type = get_class($item);

            $typeicon = [
                "Asset" => ":computer:",
                "Accessory" => ":keyboard:",
                "License" => ":floppy_disk:",
                "Consumable" => ":paperclip:"
            ];
            $directionicon = ($direction =="out" ? ":arrow_up:" : ":arrow_down");;

    }

    public static function webhookMessageBuilder($item, $target, $admin, $botname = '', $direction = null, $note = 'No note provided.')
    {
        
        $type = get_class($item);

        $typeicon = [
            "Asset" => ":computer:",
            "Accessory" => ":keyboard:",
            "License" => ":floppy_disk:",
            "Consumable" => ":paperclip:"
        ];
        $directionicon = ($direction =="out" ? ":arrow_up:" : ":arrow_down");;


    }

    public static function customWebhookMessageBuilder($item, $target, $admin, $botname = '', $direction = null, $note = 'No note provided.')
    {
        
        $type = get_class($item);

        $typeicon = [
            "Asset" => ":computer:",
            "Accessory" => ":keyboard:",
            "License" => ":floppy_disk:",
            "Consumable" => ":paperclip:"
        ];
        $directionicon = ($direction =="out" ? ":arrow_up:" : ":arrow_down");;


    }

}