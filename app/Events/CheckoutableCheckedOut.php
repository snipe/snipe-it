<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckoutableCheckedOut
{
    use Dispatchable, SerializesModels;

    public $checkoutable;
    public $checkedOutTo;
    public $checkedOutBy;
    public $note;
    public $checkout_note;
    public $total;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($checkoutable, $checkedOutTo, User $checkedOutBy, $note, $checkout_qty=null, $checkout_note=null)
    {
        $this->checkoutable = $checkoutable;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedOutBy = $checkedOutBy;
        $this->note = $note;
        if ($checkout_qty != null) {
            $this->checkout_qty         = $checkout_qty;
        }
        if ($checkout_note != null) {
            $this->checkout_note         = $checkout_note;
        }
    }
}
