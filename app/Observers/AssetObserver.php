<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\Setting;
use App\Models\Actionlog;
use Auth;

class AssetObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Asset  $asset
     * @return void
     */
    public function updating(Asset $asset)
    {

        // If the asset isn't being checked out or audited, log the update.
        // (Those other actions already create log entries.)
        if (($asset->getAttributes()['assigned_to'] == $asset->getOriginal()['assigned_to'])
            && ($asset->getAttributes()['next_audit_date'] == $asset->getOriginal()['next_audit_date'])
            && ($asset->getAttributes()['last_checkout'] == $asset->getOriginal()['last_checkout']))
        {
            $changed = [];

            foreach ($asset->getOriginal() as $key => $value) {
                if ($asset->getOriginal()[$key] != $asset->getAttributes()[$key]) {
                    $changed[$key]['old'] = $asset->getOriginal()[$key];
                    $changed[$key]['new'] = $asset->getAttributes()[$key];
                }
            }


            $logAction = new Actionlog();
            $logAction->item_type = Asset::class;
            $logAction->item_id = $asset->id;
            $logAction->created_at =  date("Y-m-d H:i:s");
            $logAction->user_id = Auth::id();
            $logAction->log_meta = json_encode($changed);
            $logAction->logaction('update');

        } 

    }


    /**
     * Listen to the Asset created event, and increment 
     * the next_auto_tag_base value in the settings table when i
     * a new asset is created.
     *
     * @param  Asset  $asset
     * @return void
     */
    public function created(Asset $asset)
    {
        if ($settings = Setting::first()) {
            $settings->increment('next_auto_tag_base');
        }

        $logAction = new Actionlog();
        $logAction->item_type = Asset::class;
        $logAction->item_id = $asset->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('create');

    }

    /**
     * Listen to the Asset deleting event.
     *
     * @param  Asset  $asset
     * @return void
     */
    public function deleting(Asset $asset)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Asset::class;
        $logAction->item_id = $asset->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}
