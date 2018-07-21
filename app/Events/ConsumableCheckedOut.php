<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConsumableCheckedOut
{
    use Dispatchable, SerializesModels;

    public $consumable;
    public $checkedOutTo;
    public $logEntry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Consumable $consumable, $checkedOutTo, Actionlog $logEntry)
    {
        $this->consumable = $consumable;
        $this->checkedOutTo = $checkedOutTo;
        $this->logEntry = $logEntry;
    }
}
