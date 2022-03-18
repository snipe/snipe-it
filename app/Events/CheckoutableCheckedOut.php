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
    public $total;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($checkoutable, $checkedOutTo, User $checkedOutBy, $note, $totalnum=null, $checkoutnote=null)
    {
        $this->checkoutable = $checkoutable;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedOutBy = $checkedOutBy;
        $this->note = $note;
        if ($totalnum != null) {
            $this->totalnum         = $totalnum;
        }
        if ($checkoutnote != null) {
            $this->checkoutnote         = $checkoutnote;
        }
    }
}
