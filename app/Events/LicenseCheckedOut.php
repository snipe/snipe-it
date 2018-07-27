<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\License;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LicenseCheckedOut
{
    use Dispatchable, SerializesModels;

    public $license;
    public $checkedOutTo;
    public $logEntry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(License $license, $checkedOutTo, User $checkedOutBy, $note)
    {
        $this->license = $license;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedOutBy = $checkedOutBy;
        $this->note = $note;
    }
}
