<?php

namespace App\Observers;

use App\Models\LicenseModel;
use App\Models\Setting;
use App\Models\Actionlog;
use Auth;

class LicenseObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  License  $license
     * @return void
     */
    public function updated(LicenseModel $license)
    {

        $logAction = new Actionlog();
        $logAction->item_type = LicenseModel::class;
        $logAction->item_id = $license->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('update');
    }


    /**
     * Listen to the License created event when
     * a new license is created.
     *
     * @param  License  $license
     * @return void
     */
    public function created(LicenseModel $license)
    {

        $logAction = new Actionlog();
        $logAction->item_type = LicenseModel::class;
        $logAction->item_id = $license->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('create');

    }

    /**
     * Listen to the License deleting event.
     *
     * @param  License  $license
     * @return void
     */
    public function deleting(LicenseModel $license)
    {
        $logAction = new Actionlog();
        $logAction->item_type = LicenseModel::class;
        $logAction->item_id = $license->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}
