<?php

namespace App\Events;

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
    public $checkedOutBy;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Component $component, $checkedOutTo, $quantity, User $checkedOutBy)
    {
        $this->component = $component;
        $this->checkedOutTo = $checkedOutTo;
        $this->quantity = $quantity;
        $this->checkedOutBy = $checkedOutBy;
    }
}
