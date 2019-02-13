<?php

namespace App\Events;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\CheckoutAcceptance;
use App\Models\Contracts\Acceptable;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckoutAccepted
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CheckoutAcceptance $acceptance)
    {
        $this->acceptance       = $acceptance;
    }
}
