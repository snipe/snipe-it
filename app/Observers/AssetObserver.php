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


        if ((isset($asset->getOriginal()['assigned_to'])) && ($asset->getAttributes()['assigned_to'] == $asset->getOriginal()['assigned_to'])
            && ($asset->getAttributes()['next_audit_date'] == $asset->getOriginal()['next_audit_date'])
            && ($asset->getAttributes()['last_checkout'] == $asset->getOriginal()['last_checkout'])
            && ($asset->getAttributes()['status_id'] == $asset->getOriginal()['status_id']))
        {
            $logAction = new Actionlog();
            $logAction->item_type = Asset::class;
            $logAction->item_id = $asset->id;
            $logAction->created_at =  date("Y-m-d H:i:s");
            $logAction->user_id = Auth::id();
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
