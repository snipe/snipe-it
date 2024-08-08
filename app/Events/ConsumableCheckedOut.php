<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConsumableCheckedOut extends CheckoutableCheckedOut
{
    use Dispatchable, SerializesModels;

    public $checkoutable;
    public $checkedOutTo;
    public $checkedOutBy;
    public $note;
    public $total;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($checkoutable, User $checkedOutBy, $quantity, $note, $checkout_qty=null, $checkoutnote=null)
    {
        $this->checkoutable = $checkoutable;        
        $this->checkedOutBy = $checkedOutBy;
        $this->$quantity = $quantity;
        $this->note = $note;
        if ($checkout_qty != null) {
            $this->checkout_qty         = $checkout_qty;
        }
        if ($checkoutnote != null) {
            $this->checkoutnote         = $checkoutnote;
        }
    }
}
