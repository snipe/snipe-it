<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FirstAdminNotification extends Notification
{
    use Queueable;

    private $_data = array();

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $content)
    {
        $this->_data['email'] = $content['email'];
        $this->_data['first_name'] = $content['first_name'];
        $this->_data['last_name'] = $content['last_name'];
        $this->_data['username'] = $content['username'];
        $this->_data['password'] = $content['password'];
        $this->_data['url'] = url('/');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('mail.welcome', ['name' => $this->_data['first_name'] . ' ' . $this->_data['last_name'] ]))
            ->markdown('notifications.FirstAdmin', $this->_data);
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
