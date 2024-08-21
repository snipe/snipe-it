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
    public $action_date; // Date setted in the hardware.checkin view at the checkin_at input, for the action log
    public $originalValues;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($checkoutable, $checkedOutTo, User $checkedOutBy, $note, $originalValues = [])
    {
        $this->checkoutable = $checkoutable;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedOutBy = $checkedOutBy;
        $this->note = $note;
        $this->originalValues = $originalValues;
    }
}
