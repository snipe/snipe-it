<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CheckinAssetNotification extends Notification
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
        $this->target = $params['target'];
        $this->item = $params['item'];
        $this->admin = $params['admin'];
        $this->note = '';
        $this->expected_checkin = '';

        if (array_key_exists('note', $params)) {
            $this->note = $params['note'];
        }

        if ($this->item->expected_checkin) {
            $this->expected_checkin = \App\Helpers\Helper::getFormattedDateObject($this->item->expected_checkin, 'date',
                false);
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $notifyBy = [];
        if (Setting::getSettings()->slack_endpoint) {
            $notifyBy[] = 'slack';
        }

        if (($this->item->requireAcceptance() == '1') || ($this->item->checkin_email()) ||  ($this->item->getEula())) {
                $notifyBy[] = 'mail';
        }
        return $notifyBy;
    }

    public function toSlack($notifiable)
    {


        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;


        $fields = [
            trans('general.administrator') => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
            trans('general.status') => $item->assetstatus->name,
            trans('general.location') => $item->location->name,
        ];

        return (new SlackMessage)
            ->content(':arrow_down: ' . class_basename(get_class($item)) . " Checked In")
            ->attachment(function ($attachment) use ($item, $note, $admin, $fields) {
                $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                    ->fields($fields)
                    ->content($note);
            });



    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\sMessages\MailMessage
     */
    public function toMail($notifiable)
    {

        $fields = [];

        // Check if the item has custom fields associated with it
        if (($this->item->model) && ($this->item->model->fieldset)) {
            $fields = $this->item->model->fieldset->fields;
        }



        return (new MailMessage)->markdown('notifications.markdown.checkin-asset',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
                'fields'        => $fields,
                'expected_checkin'  => $this->expected_checkin,
            ])
            ->subject('Asset checked in');

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
