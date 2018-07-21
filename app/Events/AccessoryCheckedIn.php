<?php

namespace App\Events;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccessoryCheckedIn
{
    use Dispatchable, SerializesModels;

    public $accessory;
    public $checkedOutTo;
    public $checkedInBy;
    public $note;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Accessory $accessory, $checkedOutTo, User $checkedInBy, $note)
    {
        $this->accessory    = $accessory;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedInBy  = $checkedInBy;
        $this->note         = $note;
    }
}
