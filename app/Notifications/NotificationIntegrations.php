<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\SlackMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;

//discrod channels below use bot api
//use NotificationChannels\Discord\DiscordChannel;
//use NotificationChannels\Discord\DiscordMessage;

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
                //TO DO: This should be changed to a maintained DiscordWebhook that supports "embeds", update routes as well.
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
 * 
 * $item = what is being checked out, get type from class
 * $target = who/what its being checked out to
 * $direction = "out" or "in" what
 * $admin = checked in/out by
 * 
 *       $this->item = $accessory;
 *       $this->target = $checkedOutTo;
 *       $this->admin = $checkedInby;
 *       $this->note = $note;
 *       $this->settings = Setting::getSettings();
 */

    public static function msteamsMessageBuilder($item, $target, $admin, $direction, $note, $expectedCheckin)
    {
          
            $type = class_basename($item);

            $typeicon = [
                "Asset" => "&#x1F4BB;",
                "Accessory" => "&#x2328;",
                "License" => "&#x1F4BE;",
                "Consumable" => "&#x1F4CD;"
            ];

            $directionicon = ($direction == "out" ? "&#x2B06;" : "&#x2B07;");
            $tofrom = ($direction == "out" ? "To" : "From");
        
            //in php8 this can be rewritten using nullsafe operator on Fluent interface method chaining
            $msTeamsMessage = (new MicrosoftTeamsMessage)->create();

            $msTeamsMessage->to(Setting::getSettings()->msteams_endpoint)
            ->type('success')
            ->addStartGroupToSection($sectionId = 'action_msteams')
            ->title(''.$directionicon.''.$typeicon[$type].' '.$type.' Checked '.$direction.': <a href=' . $item->present()->viewUrl() . '>' . $item->present()->fullName() . '</a>', $params = ['section' => 'action_msteams']);
            if ($note != '') $msTeamsMessage ->content($note, $params = ['section' => 'action_msteams']);
            $msTeamsMessage->fact(''.$tofrom.'','<a href='.$target->present()->viewUrl().'>'.$target->present()->fullName().'</a>', $sectionId = 'action_msteams')
            ->fact('By', '<a href='.$admin->present()->viewUrl().'>'.$admin->present()->fullName().'</a>', $sectionId = 'action_msteams');
            if ($expectedCheckin != '') $msTeamsMessage->fact('Expected Checkin', $expectedCheckin, $sectionId = 'action_msteams');
            if ($direction == 'in')  $msTeamsMessage->fact('Status', $item->assetstatus->name, $sectionId = 'action_msteams');
            $msTeamsMessage->button('View in Browser', ''.$target->present()->viewUrl().'', $params = ['section' => 'action_msteams']);
    
            return $msTeamsMessage;
    }

    public static function slackMessageBuilder($item, $target, $admin, $direction, $note, $expectedCheckin, $botname = 'Snipe-Bot')
    {
        
            $type = class_basename($item);

            $typeicon = [
                "Asset" => ":computer:",
                "Accessory" => ":keyboard:",
                "License" => ":floppy_disk:",
                "Consumable" => ":paperclip:"
            ];

            $directionicon = ($direction =="out" ? ":arrow_up:" : ":arrow_down:");
            $tofrom = ($direction == "out" ? "To" : "From");

            //set optional fields 
            $fields = [
                ''.$tofrom.'' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
                'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
            ];
   
            if ($expectedCheckin && $expectedCheckin != '') {
                $fields['Expected Checkin'] = $expectedCheckin;
            }
            if ($direction == "in" && $item->location){
                $fields[trans('general.location')] = $item->location->name;
                $fields[trans('general.status')] = $item->assetstatus->name;
                
            }

            $slackMessage = new SlackMessage();
            
            $slackMessage ->content(''.$directionicon.''.$typeicon[$type].' '.$type.' Checked '.$direction.'')
                ->from($botname)
                ->attachment(function ($attachment) use ($target, $item, $note, $admin, $fields, $tofrom) {
                    $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                        ->fields($fields)
                        ->content($note);
                });
                return $slackMessage;
    }

    public static function webhookMessageBuilder($item, $target, $admin, $direction, $note, $expectedCheckin, $botname = 'Snipe-Bot')
    {
        
        $type = class_basename($item);

        $typeicon = [
            "Asset" => ":computer:",
            "Accessory" => ":keyboard:",
            "License" => ":floppy_disk:",
            "Consumable" => ":paperclip:"
        ];
        $directionicon = ($direction =="out" ? ":arrow_up:" : ":arrow_down:");
        $tofrom = ($direction == "out" ? "To" : "From");
  
      return WebhookMessage::create()
        ->data([
                'content' => ''.$directionicon.''.$typeicon[$type].' **'.$type.' Checked '.$direction.'**['. $item->present()->fullName() .']('.$item->present()->viewUrl().')
            *'.$tofrom.':* ['.$target->present()->fullName().']('.$target->present()->viewUrl().')
            *By:* ['.$admin->present()->fullName().']('.$admin->present()->viewUrl().')\\r\\n'.($note != '' ? '*Note*: '.$note.'' : '').'
            '.($direction == 'in' ? ''.trans('general.location').' : '.$item->location->name.'': '').'
            '.'[View in Browser]('.$target->present()->viewUrl().')',
            
        ])
        ->header('Content-Type', 'application/json');

    }

}