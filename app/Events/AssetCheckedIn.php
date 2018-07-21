<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssetCheckedIn
{
    use Dispatchable, SerializesModels;

    public $asset;
    public $checkedOutTo;
    public $checkedInBy;
    public $note;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Asset $asset, $checkedOutTo, User $checkedInBy, $note)
    {
        $this->asset = $asset;
        $this->checkedOutTo = $checkedOutTo;
        $this->checkedInBy = $checkedInBy;
        $this->note = $note;
    }
}
