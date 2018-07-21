<?php

namespace App\Events;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssetCheckedOut
{
    use Dispatchable, SerializesModels;

    public $asset;
    public $checkedOutTo;
    public $logEntry;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Asset $asset, $checkedOutTo, Actionlog $logEntry)
    {
        $this->asset = $asset;
        $this->checkedOutTo = $checkedOutTo;
        $this->logEntry = $logEntry;
    }
}
