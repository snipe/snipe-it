<?php

namespace App\Observers;

use App\Models\Accessory;
use App\Models\Actionlog;

class AccessoryObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Accessory  $accessory
     * @return void
     */
    public function updated(Accessory $accessory)
    {
        $attributes = $accessory->getAttributes();
        $attributesOriginal = $accessory->getRawOriginal();
        $restoring_or_deleting = false;

        // This is a gross hack to prevent the double logging when restoring an asset
        if (array_key_exists('deleted_at', $attributes)  && array_key_exists('deleted_at', $attributesOriginal)){
            $restoring_or_deleting = (($attributes['deleted_at'] != $attributesOriginal['deleted_at']));
        }



        if (!$restoring_or_deleting) {
            $changed = [];
            foreach ($accessory->getRawOriginal() as $key => $value) {
                if ((array_key_exists($key, $accessory->getAttributes())) && ($accessory->getRawOriginal()[$key] != $accessory->getAttributes()[$key])) {
                    $changed[$key]['old'] = $accessory->getRawOriginal()[$key];
                    $changed[$key]['new'] = $accessory->getAttributes()[$key];
                }
            }
        }


        if (empty($changed)){
            return;
        }

        $logAction = new Actionlog();
        $logAction->item_type = Accessory::class;
        $logAction->item_id = $accessory->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
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
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');

        if($accessory->imported) {
            $logAction->setActionSource('importer');
        }
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
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('delete');
    }
}
