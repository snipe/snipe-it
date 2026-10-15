<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;
use Symfony\Component\Mime\Email;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $expire_date;
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public User $user
    )
    {
        // Password::broker() is typed to return the interface
        // Illuminate\Contracts\Auth\PasswordBroker, which doesn't
        // declare createToken(). The concrete Illuminate\Auth\Passwords\
        // PasswordBroker does. Narrow the type locally so PHPStan can
        // resolve the method against the concrete class.
        /** @var \Illuminate\Auth\Passwords\PasswordBroker $broker */
        $broker = Password::broker('invites');

        $this->token = $broker->createToken($user);
        $this->expire_date = now()->addMinutes((int) config('auth.passwords.invites.expire', 2880))->format('F j, Y, g:i a');
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
     * @return MailMessage
     */
    public function toMail()
    {

        return (new MailMessage)
            ->subject('👋 '.trans('mail.welcome', ['name' => $this->user->first_name.' '.$this->user->last_name]))
            ->markdown('notifications.Welcome',
                $this->user->toArray() + [
                    'expire_date' => $this->expire_date,
                    'token' => $this->token,
                ])
            ->withSymfonyMessage(function (Email $message) {
                $message->getHeaders()->addTextHeader(
                    'X-System-Sender', 'Snipe-IT'
                );
            });
    }
}
