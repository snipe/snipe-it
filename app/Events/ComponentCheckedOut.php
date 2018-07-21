<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\Component;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComponentCheckedOut
{
    use Dispatchable, SerializesModels;

    public $component;
    public $checkedOutTo;
    public $logEntry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Component $component, $checkedOutTo, Actionlog $logEntry)
    {
        $this->component = $component;
        $this->checkedOutTo = $checkedOutTo;
        $this->logEntry = $logEntry;
    }
}
