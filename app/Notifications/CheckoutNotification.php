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
        //
        $this->params = $params;
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
        $item = $this->params['item'];

        if (class_basename(get_class($this->params['item']))=='Asset') {
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

        return (new SlackMessage)
            ->success()
            ->content(class_basename(get_class($this->params['item'])) . " Checked Out")
            ->attachment(function ($attachment) use ($notifiable) {
                $item = $this->params['item'];
                $admin_user = $this->params['admin'];
                $target = $this->params['target'];
                $fields = [
                    'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
                    'By' => '<'.$admin_user->present()->viewUrl().'|'.$admin_user->present()->fullName().'>'
                ];
                array_key_exists('note', $this->params) && $fields['Notes'] = $this->params['note'];

                $attachment->title($item->name, $item->present()->viewUrl())
                ->fields($fields);
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
        if (class_basename(get_class($this->params['item']))=='Asset') {

            //TODO: Expand for non assets.
            $item = $this->params['item'];
            $admin_user = $this->params['admin'];
            $target = $this->params['target'];
            $data = [
                'eula' => method_exists($item, 'getEula') ? $item->getEula() : '',
                'first_name' => $target->present()->fullName(),
                'item_name' => $item->present()->name(),
                'checkout_date' => $item->last_checkout,
                'expected_checkin' => ($item->expected_checkin) ? $item->expected_checkin->format('Y-m-d') : '',
                'item_tag' => $item->asset_tag,
                'note' => $this->params['note'],
                'item_serial' => $item->serial,
                'require_acceptance' => method_exists($item, 'requireAcceptance') ? $item->requireAcceptance() : '',
                'log_id' => $this->params['log_id'],
                'manufacturer_name' => $item->model->manufacturer->name,
                'model_name' => $item->model->name,
                'model_number' => $item->model->model_number,
            ];

            if ((method_exists($item, 'requireAcceptance') && ($item->requireAcceptance() == '1'))
                || (method_exists($item, 'getEula') && ($item->getEula()))
            ) {
                return (new MailMessage)
                    ->view('emails.accept-asset', $data)
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
