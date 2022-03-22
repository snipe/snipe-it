<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConsumableCheckedOut
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
    public function __construct($checkoutable, User $checkedOutBy, $quantity, $note, $totalnum=null, $checkoutnote=null)
    {
        $this->checkoutable = $checkoutable;        
        $this->checkedOutBy = $checkedOutBy;
        $this->$quantity = $quantity;
        $this->note = $note;
        if ($totalnum != null) {
            $this->totalnum         = $totalnum;
        }
        if ($checkoutnote != null) {
            $this->checkoutnote         = $checkoutnote;
        }
    }
}
