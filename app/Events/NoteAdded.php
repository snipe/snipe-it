<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoteAdded
{
    use Dispatchable, SerializesModels;
    public $itemNoteAddedOn;
    public $note;
    public $noteAddedBy;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($itemNoteAddedOn, User $noteAddedBy, $note)
    {
        $this->itemNoteAddedOn = $itemNoteAddedOn;
        $this->note = $note;
        $this->noteAddedBy = $noteAddedBy;
    }
}