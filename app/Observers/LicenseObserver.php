<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\License;
use Auth;

class LicenseObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  License  $license
     * @return void
     */
    public function updating(License $license)
    {
        $changed = [];

        foreach ($license->getRawOriginal() as $key => $value) {
            if ($license->getRawOriginal()[$key] != $license->getAttributes()[$key]) {
                $changed[$key]['old'] = $license->getRawOriginal()[$key];
                $changed[$key]['new'] = $license->getAttributes()[$key];
            }
        }

        if (empty($changed)){
            return;
        }

        $logAction = new Actionlog();
        $logAction->item_type = License::class;
        $logAction->item_id = $license->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();
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
        $logAction->user_id = Auth::id();
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
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}