<?php

namespace App\Mail;

use App\Models\Accessory;
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

class CheckoutAccessoryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(Accessory $accessory, $checkedOutTo, User $checkedOutBy, $acceptance, $note)
    {
        $this->item = $accessory;
        $this->admin = $checkedOutBy;
        $this->note = $note;
        $this->checkout_qty = $accessory->checkout_qty;
        $this->target = $checkedOutTo;
        $this->acceptance = $acceptance;
        $this->settings = Setting::getSettings();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $from = new Address(config('mail.from.address'), config('mail.from.name'));

        return new Envelope(
            from: $from,
            subject: (trans('mail.Accessory_Checkout_Notification')),
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
            markdown: 'mail.markdown.checkout-accessory',
            with:   [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'target'        => $this->target,
                'eula'          => $eula,
                'req_accept'    => $req_accept,
                'accept_url'    => $accept_url,
                'checkout_qty'  => $this->checkout_qty,
            ],
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
