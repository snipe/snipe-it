<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Consumable;
use Auth;

class ConsumableObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Consumable  $consumable
     * @return void
     */
    public function updating(Consumable $consumable)
    {
        $changed = [];

        foreach ($consumable->getRawOriginal() as $key => $value) {
            if ($consumable->getRawOriginal()[$key] != $consumable->getAttributes()[$key]) {
                $changed[$key]['old'] = $consumable->getRawOriginal()[$key];
                $changed[$key]['new'] = $consumable->getAttributes()[$key];
            }
        }

        if (empty($changed)){
            return;
        }

        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();
        $logAction->log_meta = json_encode($changed);
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
        $logAction->created_at = date('Y-m-d H:i:s');
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
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}