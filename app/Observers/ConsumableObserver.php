<?php

namespace App\Observers;

use App\Models\Consumable;
use App\Models\Setting;
use App\Models\Actionlog;
use Auth;

class ConsumableObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Consumable  $consumable
     * @return void
     */
    public function updated(Consumable $consumable)
    {

        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('update');
    }


    /**
     * Listen to the Consumable created event when
     * a new consumable is created.
     *
     * @param  Consumable  $consumable
     * @return void
     */
    public function created(Consumable $consumable)
    {

        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('create');

    }

    /**
     * Listen to the Consumable deleting event.
     *
     * @param  Consumable  $consumable
     * @return void
     */
    public function deleting(Consumable $consumable)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}
