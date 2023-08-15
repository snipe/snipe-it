<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Location;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
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
        $attributesOriginal = $asset->getRawOriginal();
        $same_checkout_counter = false;
        $same_checkin_counter = false;

        if (array_key_exists('checkout_counter', $attributes) && array_key_exists('checkout_counter', $attributesOriginal)){
            $same_checkout_counter = (($attributes['checkout_counter'] == $attributesOriginal['checkout_counter']));
        }

        if (array_key_exists('checkin_counter', $attributes)  && array_key_exists('checkin_counter', $attributesOriginal)){
            $same_checkin_counter = (($attributes['checkin_counter'] == $attributesOriginal['checkin_counter']));
        }

        // If the asset isn't being checked out or audited, log the update.
        // (Those other actions already create log entries.)
	if (($attributes['assigned_to'] == $attributesOriginal['assigned_to']) 
	    && ($same_checkout_counter) && ($same_checkin_counter)
            && ((isset( $attributes['next_audit_date']) ? $attributes['next_audit_date'] : null) == (isset($attributesOriginal['next_audit_date']) ? $attributesOriginal['next_audit_date']: null))
            && ($attributes['last_checkout'] == $attributesOriginal['last_checkout']))
        {
            $changed = [];


            foreach ($asset->getRawOriginal() as $key => $value) {
                if ($asset->getRawOriginal()[$key] != $asset->getAttributes()[$key]) {
                    $changed[$key]['old'] = $asset->getRawOriginal()[$key];
                    $changed[$key]['new'] = $asset->getAttributes()[$key];
                }
	    }

               $changed= $this->changedInfo($changed, $asset);

	    if (empty($changed)){
	        return;
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
     * This takes the ids of the changed attributes and returns the names instead for the history view of an Asset
     *
     * @param  $asset
     * @return void
     */
    public function changedInfo($changed, $asset){

                if(array_key_exists('rtd_location_id',$changed)) {
                    $changed['rtd_location_id']['old'] = Location::find($changed['rtd_location_id']['old'])->name;
                    $changed['rtd_location_id']['new'] = $asset->defaultloc->name;
                }
               if(array_key_exists('model_id', $changed)) {
                   $changed['model_id']['old'] = AssetModel::find($changed['model_id']['old'])->name;
                   $changed['model_id']['new'] = $asset->model->name;
               }
                if(array_key_exists('company_id', $changed)) {
                    $changed['company_id']['old'] = Company::find($changed['company_id']['old'])->name;
                    $changed['company_id']['new'] = $asset->company->name;
                }
                if(array_key_exists('supplier_id', $changed)) {
                    $changed['supplier_id']['old'] = Supplier::find($changed['supplier_id']['old'])->name;
                    $changed['supplier_id']['new'] = $asset->supplier->name;
                }

            return $changed;

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
            $tag = $asset->asset_tag;
            $prefix = $settings->auto_increment_prefix;
            $number = substr($tag, strlen($prefix));
            // IF - auto_increment_assets is on, AND (the prefix matches the start of the tag OR there is no prefix)
            //      AND the rest of the string after the prefix is all digits, THEN...
            if ($settings->auto_increment_assets && (strpos($tag, $prefix) === 0 || $prefix=='') && preg_match('/\d+/',$number) === 1) {
                // new way of auto-trueing-up auto_increment ID's
                $next_asset_tag = intval($number, 10) + 1;
                // we had to use 'intval' because the $number could be '01234' and
                // might get interpreted in Octal instead of decimal

                // only modify the 'next' one if it's *bigger* than the stored base
                //
                if($next_asset_tag > $settings->next_auto_tag_base) {
                    $settings->next_auto_tag_base = $next_asset_tag;
                    $settings->save();
                }

            } else {
                // legacy method
                $settings->increment('next_auto_tag_base');
                $settings->save();
            }
        }

        $logAction = new Actionlog();
        $logAction->item_type = Asset::class; // can we instead say $logAction->item = $asset ?
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
