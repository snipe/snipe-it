<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\SnipeModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class CheckoutNotification extends Notification
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
        $this->log_id = $params['log_id'];
        $this->note = '';
        if (array_key_exists('note', $params)) {
            $this->note = $params['note'];
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
        $item = $this->item;

        if (class_basename(get_class($item))=='Asset') {
            if ((method_exists($item, 'requireAcceptance') && ($item->requireAcceptance() == '1'))
                || (method_exists($item, 'getEula') && ($item->getEula()))
            ) {
                $notifyBy[] = 'mail';
            }
        }
        return $notifyBy;
    }

    public function toSlack($notifiable)
    {

        \Log::debug('Trigger slack ');
        $target = $this->target;
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;

        $fields = [
            'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
            'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>'
        ];



        return (new SlackMessage)
            ->content(':arrow_up: ' . class_basename(get_class($item)) . " Checked Out")
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {


        $eula =  method_exists($this->item, 'getEula') ? $this->item->getEula() : '';
        $req_accept = method_exists($this->item, 'requireAcceptance') ? $this->item->requireAcceptance() : 0;
        $last_checkout = ($this->item->last_checkout) ? \App\Helpers\Helper::getFormattedDateObject($this->item->last_checkout, 'date', false) : '';
        $expected_checkin = ($this->item->expected_checkin) ? \App\Helpers\Helper::getFormattedDateObject($this->item->expected_checkin, 'date', false) : '';

        if (class_basename(get_class($this->item))=='Asset') {

            $fields = [];

            // Check if the item has custom fields associated with it
            if (($this->item->model) && ($this->item->model->fieldset)) {
                $fields = $this->item->model->fieldset->fields;
            }


            if ((method_exists($this->item, 'requireAcceptance') && ($this->item->requireAcceptance() == '1'))
                || (method_exists($this->item, 'getEula') && ($this->item->getEula()))
            ) {

                return (new MailMessage)->markdown('notifications.markdown.checkout',
                    [
                        'item'          => $this->item,
                        'admin'         => $this->admin,
                        'note'          => $this->note,
                        'log_id'        => $this->note,
                        'target'        => $this->target,
                        'fields'        => $fields,
                        'eula'          => $eula,
                        'req_accept'    => $req_accept,
                        'accept_url'    =>  url('/').'/account/accept-asset/'.$this->log_id,
                        'last_checkout' => $last_checkout,
                        'expected_checkin'  => $expected_checkin,
                    ])
                    ->subject(trans('mail.Confirm_asset_delivery'));

            }
        }




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
