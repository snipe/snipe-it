<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Symfony\Component\Mime\Email;

class InventoryAlert extends Notification implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new notification instance.
     */
    public function __construct(
        public $items,
        public $threshold = 0
    )
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return (! empty($this->items) && $this->threshold !== null) ? ['mail'] : [];

    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail()
    {
        $message = (new MailMessage)->markdown(
            'notifications.markdown.report-low-inventory',
            [
                'items' => $this->items,
                'threshold' => $this->threshold,
            ]
        )
            ->subject('⚠️ '.trans('mail.Low_Inventory_Report'))
            ->withSymfonyMessage(function (Email $message) {
                $message->getHeaders()->addTextHeader(
                    'X-System-Sender', 'Snipe-IT'
                );
            });

        return $message;
    }
}
