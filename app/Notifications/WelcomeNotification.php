<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    private $_data = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $content)
    {
        $this->_data['email'] = htmlspecialchars_decode($content['email']);
        $this->_data['first_name'] = htmlspecialchars_decode($content['first_name']);
        $this->_data['last_name'] = htmlspecialchars_decode($content['last_name']);
        $this->_data['username'] = htmlspecialchars_decode($content['username']);
        $this->_data['password'] = htmlspecialchars_decode($content['password']);
        $this->_data['url'] = config('app.url');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage())
            ->subject(trans('mail.welcome', ['name' => $this->_data['first_name'].' '.$this->_data['last_name']]))
            ->markdown('notifications.Welcome', $this->_data);
    }
}
