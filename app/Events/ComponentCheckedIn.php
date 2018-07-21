<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\Component;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComponentCheckedIn
{
    use Dispatchable, SerializesModels;

    public $component;
    public $checkedOutTo;
    public $checkedInBy;
    public $quantity;
    public $note;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Component $component, $checkedOutTo, User $checkedInBy, $quantity, $note)
    {
        $this->component = $component;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedInBy = $checkedInBy;
        $this->quantity = $quantity;
        $this->note = $note;
    }
}
