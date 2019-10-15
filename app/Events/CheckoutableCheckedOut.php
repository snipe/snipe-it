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
    public $isBulkCheckoutEmail;
    public $isIndividual;
    public $dates;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($checkoutable, $checkedOutTo, User $checkedOutBy, $note, $isBulkCheckoutEmail = false, $isIndividual = true, $dates = null)
    {
        $this->isBulkCheckoutEmail  = $isBulkCheckoutEmail;
        $this->checkoutable         = $checkoutable;
        $this->checkedOutTo         = $checkedOutTo;
        $this->checkedOutBy         = $checkedOutBy;
        $this->isIndividual         = $isIndividual;
        $this->dates                = $dates;
        $this->note                 = $note;
    }
}
