<?php

namespace App\Mail;

use App\Models\Consumable;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckoutConsumableMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(Consumable $consumable, $checkedOutTo, User $checkedOutBy, $acceptance, $note)
    {
        $this->item = $consumable;
        $this->admin = $checkedOutBy;
        $this->note = $note;
        $this->target = $checkedOutTo;
        $this->acceptance = $acceptance;

        $this->settings = Setting::getSettings();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $from = null;
        $cc = [];

        if (!empty(Setting::getSettings()->alert_email)) {
            $from = new Address(Setting::getSettings()->alert_email);
        }
        if (!empty(Setting::getSettings()->admin_cc_email)) {
            $cc[] = new Address(Setting::getSettings()->admin_cc_email);
        }

        return new Envelope(
            from: $from ?? new Address('default@example.com', 'Default Sender'),
            cc: $cc,
            subject: trans('mail.Confirm_consumable_delivery'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        Log::debug($this->item->getImageUrl());
        $eula = $this->item->getEula();
        $req_accept = $this->item->requireAcceptance();

        $accept_url = is_null($this->acceptance) ? null : route('account.accept.item', $this->acceptance);

        return new Content(
            markdown: 'mail.markdown.checkout-consumable',
            with:   [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
                'eula'          => $eula,
                'req_accept'    => $req_accept,
                'accept_url'    => $accept_url,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
