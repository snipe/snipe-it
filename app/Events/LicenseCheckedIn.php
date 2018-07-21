<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\License;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LicenseCheckedIn
{
    use Dispatchable, SerializesModels;

    public $license;
    public $checkedOutTo;
    public $checkedInBy;
    public $note;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(License $license, $checkedOutTo, User $checkedInBy, $note)
    {
        $this->license = $license;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedInBy = $checkedInBy;
        $this->note = $note;
    }
}
