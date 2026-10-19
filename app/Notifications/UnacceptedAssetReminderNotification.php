<?php

namespace App\Notifications;

use App\Models\CheckoutAcceptance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Nudges a user about pending acceptances still on their plate. One
 * notification per assignee with the total count, not one per
 * acceptance. Replaced the standalone UnacceptedAssetReminderMail so
 * every reminder flow (snipeit:acceptance-reminder console command,
 * the per-user Resend-reminder button on the user show page, the
 * /unaccepted-acceptances bulk UI, and the API send-reminders
 * endpoint) ships through the same Laravel notification channel.
 */
class UnacceptedAssetReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public CheckoutAcceptance $acceptance,
        public int $count,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        // Locale is picked up automatically from User::preferredLocale()
        // (HasLocalePreference contract), so this doesn't need to
        // branch on $notifiable->locale the way the old Mailable did.
        return (new MailMessage)
            ->subject(trans('mail.unaccepted_asset_reminder'))
            ->markdown('notifications.markdown.asset-reminder', [
                'count' => $this->count,
                'assigned_to' => $this->acceptance->assignedTo?->present()->fullName,
                'link' => route('account.accept'),
                'accept_url' => route('account.accept'),
            ]);
    }
}
