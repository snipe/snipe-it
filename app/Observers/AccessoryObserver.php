<?php

namespace App\Observers;

use App\Models\Accessory;
use App\Models\Actionlog;
use Auth;

class AccessoryObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Accessory  $accessory
     * @return void
     */
    public function updating(Accessory $accessory)
    {
        $changed = [];

        foreach ($accessory->getRawOriginal() as $key => $value) {
            if ($accessory->getRawOriginal()[$key] != $accessory->getAttributes()[$key]) {
                $changed[$key]['old'] = $accessory->getRawOriginal()[$key];
                $changed[$key]['new'] = $accessory->getAttributes()[$key];
            }
        }

        if (empty($changed)){
            return;
        }

        $logAction = new Actionlog();
        $logAction->item_type = Accessory::class;
        $logAction->item_id = $accessory->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();
        $logAction->log_meta = json_encode($changed);
        $logAction->logaction('update');
    }

    /**
     * Listen to the Accessory created event when
     * a new accessory is created.
     *
     * @param  Accessory  $accessory
     * @return void
     */
    public function created(Accessory $accessory)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Accessory::class;
        $logAction->item_id = $accessory->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();
        $logAction->logaction('create');
    }

    /**
     * Listen to the Accessory deleting event.
     *
     * @param  Accessory  $accessory
     * @return void
     */
    public function deleting(Accessory $accessory)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Accessory::class;
        $logAction->item_id = $accessory->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}