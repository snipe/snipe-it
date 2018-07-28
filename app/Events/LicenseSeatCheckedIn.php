<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LicenseCheckedIn
{
    use Dispatchable, SerializesModels;

    public $licenseSeat;
    public $checkedOutTo;
    public $checkedInBy;
    public $note;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LicenseSeat $licenseSeat, $checkedOutTo, User $checkedInBy, $note)
    {
        $this->licenseSeat = $licenseSeat;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedInBy = $checkedInBy;
        $this->note = $note;
    }
}
