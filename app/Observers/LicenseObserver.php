<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\License;

class LicenseObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  License  $license
     * @return void
     */
    public function updated(License $license)
    {
        $attributes = $license->getAttributes();
        $attributesOriginal = $license->getRawOriginal();
        $restoring_or_deleting = false;

        // This is a gross hack to prevent the double logging when restoring an asset
        if (array_key_exists('deleted_at', $attributes)  && array_key_exists('deleted_at', $attributesOriginal)){
            $restoring_or_deleting = (($attributes['deleted_at'] != $attributesOriginal['deleted_at']));
        }



        if (!$restoring_or_deleting) {
            $changed = [];
            foreach ($license->getRawOriginal() as $key => $value) {
                if ((array_key_exists($key, $license->getAttributes())) && ($license->getRawOriginal()[$key] != $license->getAttributes()[$key])) {
                    $changed[$key]['old'] = $license->getRawOriginal()[$key];
                    $changed[$key]['new'] = $license->getAttributes()[$key];
                }
            }
        }


        if (empty($changed)){
            return;
        }

        $logAction = new Actionlog();
        $logAction->item_type = License::class;
        $logAction->item_id = $license->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->log_meta = json_encode($changed);
        $logAction->logaction('update');
    }

    /**
     * Listen to the License created event when
     * a new license is created.
     *
     * @param  License  $license
     * @return void
     */
    public function created(License $license)
    {
        $logAction = new Actionlog();
        $logAction->item_type = License::class;
        $logAction->item_id = $license->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
        if($license->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('create');
    }

    /**
     * Listen to the License deleting event.
     *
     * @param  License  $license
     * @return void
     */
    public function deleting(License $license)
    {
        $logAction = new Actionlog();
        $logAction->item_type = License::class;
        $logAction->item_id = $license->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->logaction('delete');
    }
}
