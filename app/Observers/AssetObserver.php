<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Setting;
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
        $attributes = $asset->getAttributes();
        $attributesOriginal = $asset->getOriginal();
        
        // If the asset isn't being checked out or audited, log the update.
        // (Those other actions already create log entries.)
          if (($attributes['assigned_to'] == $attributesOriginal['assigned_to'])
            && ((isset( $attributes['next_audit_date']) ? $attributes['next_audit_date'] : null) == (isset($attributesOriginal['next_audit_date']) ? $attributesOriginal['next_audit_date']: null))
            && ($attributes['last_checkout']   == $attributesOriginal['last_checkout']))
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
            $logAction->created_at = date('Y-m-d H:i:s');
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
        if ($settings = Setting::getSettings()) {
            $settings->increment('next_auto_tag_base');
            $settings->save();
        }

        $logAction = new Actionlog();
        $logAction->item_type = Asset::class;
        $logAction->item_id = $asset->id;
        $logAction->created_at = date('Y-m-d H:i:s');
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
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();
        $logAction->logaction('delete');
    }
}
