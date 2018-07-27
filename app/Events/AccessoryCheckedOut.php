<?php

namespace App\Events;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccessoryCheckedOut
{
    use Dispatchable, SerializesModels;

    public $accessory;
    public $checkedOutTo;
    public $logEntry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Accessory $accessory, $checkedOutTo, User $checkedOutBy, $note)
    {
        $this->accessory = $accessory;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedOutBy = $checkedOutBy;
        $this->note = $note;
    }
}
