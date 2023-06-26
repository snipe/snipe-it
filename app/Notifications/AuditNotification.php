<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class AuditNotification extends Notification
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
    public function __construct($params)
    {
        //
        $this->settings = Setting::getSettings();
        $this->params = $params;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        $notifyBy = [];
        if (Setting::getSettings()->webhook_endpoint) {
            $notifyBy[] = 'slack';
        }

        return $notifyBy;
    }

    public function toSlack()
    {
        $channel = ($this->settings->webhook_channel) ? $this->settings->webhook_channel : '';
        return (new SlackMessage)
            ->success()
            ->content(class_basename(get_class($this->params['item'])).' Audited')
            ->from(($this->settings->webhook_botname) ? $this->settings->webhook_botname : 'Snipe-Bot')
            ->to($channel)
            ->attachment(function ($attachment) {
                $item = $this->params['item'];
                $admin_user = $this->params['admin'];
                $fields = [
                    'By' => '<'.$admin_user->present()->viewUrl().'|'.$admin_user->present()->fullName().'>',
                ];
                array_key_exists('note', $this->params) && $fields['Notes'] = $this->params['note'];
                array_key_exists('location', $this->params) && $fields['Location'] = $this->params['location'];

                $attachment->title($item->present()->name, $item->present()->viewUrl())
                    ->fields($fields);
            });
    }
}
