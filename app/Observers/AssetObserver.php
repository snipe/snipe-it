<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Location;
use App\Models\Setting;
use App\Models\Supplier;
use Auth;
use Carbon\Carbon;

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
            $changed = $this->changedInfo($changed);

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
            // IF - auto_increment_assets is on, AND (there is no prefix OR the prefix matches the start of the tag)
            //      AND the rest of the string after the prefix is all digits, THEN...
            if ($settings->auto_increment_assets && ($prefix=='' || strpos($tag, $prefix) === 0) && preg_match('/\d+/',$number) === 1) {
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
   
    public function saving(Asset $asset)
    {
        //determine if calculated eol and then calculate it - this should only happen on a new asset
        if(is_null($asset->asset_eol_date) && !is_null($asset->purchase_date) && !is_null($asset->model->eol)){
            $asset->asset_eol_date = $asset->purchase_date->addMonths($asset->model->eol)->format('Y-m-d');
            $asset->eol_explicit = false; 
        } 

       //determine if explicit and set eol_explit to true 
       if(!is_null($asset->asset_eol_date) && !is_null($asset->purchase_date)) {
            if($asset->model->eol) {
                $months = Carbon::parse($asset->asset_eol_date)->diffInMonths($asset->purchase_date); 
                if($months != $asset->model->eol) {
                    $asset->eol_explicit = true;
                }
            }
       } elseif (!is_null($asset->asset_eol_date) && is_null($asset->purchase_date)) {
           $asset->eol_explicit = true;
       }
       if ((!is_null($asset->asset_eol_date)) && (!is_null($asset->purchase_date)) && (is_null($asset->model->eol))) {
           $asset->eol_explicit = true;
       }

    }
    /**
     * This takes the ids of the changed attributes and returns the names instead for the history view of an Asset
     *
     * @param  array $clean_meta
     * @return array
     */

    public function changedInfo(array $changed)
    {   $location = Location::withTrashed()->get();
        $supplier = Supplier::withTrashed()->get();
        $model = AssetModel::withTrashed()->get();
        $company = Company::get();


        if(array_key_exists('rtd_location_id',$changed)) {

            $changed['rtd_location_id']['old'] = $changed['rtd_location_id']['old'] ? "[id: " . $changed['rtd_location_id']['old'] . "] " . $location->find($changed['rtd_location_id']['old'])->name : trans('general.unassigned');
            $changed['rtd_location_id']['new'] = $changed['rtd_location_id']['new'] ? "[id: " . $changed['rtd_location_id']['new'] . "] " . $location->find($changed['rtd_location_id']['new'])->name : trans('general.unassigned');
            $changed['Default Location'] = $changed['rtd_location_id'];
            unset($changed['rtd_location_id']);
        }
        if(array_key_exists('location_id', $changed)) {

            $changed['location_id']['old'] = $changed['location_id']['old'] ? "[id: " . $changed['location_id']['old'] . "] " . $location->find($changed['location_id']['old'])->name : trans('general.unassigned');
            $changed['location_id']['new'] = $changed['location_id']['new'] ? "[id: " . $changed['location_id']['new'] . "] " . $location->find($changed['location_id']['new'])->name : trans('general.unassigned');
            $changed['Current Location'] = $changed['location_id'];
            unset($changed['location_id']);
        }
        if(array_key_exists('model_id', $changed)) {

            $oldModel = $model->find($changed['model_id']['old']);
            $oldModelName = $oldModel->name ?? trans('admin/models/message.deleted');

            $newModel = $model->find($changed['model_id']['new']);
            $newModelName = $newModel->name ?? trans('admin/models/message.deleted');

            $changed['model_id']['old'] = "[id: ".$changed['model_id']['old']."] ".$oldModelName;
            $changed['model_id']['new'] = "[id: ".$changed['model_id']['new']."] ".$newModelName; /** model is required at asset creation */

            $changed['Model'] = $changed['model_id'];
            unset($changed['model_id']);
        }
        if(array_key_exists('company_id', $changed)) {

            $oldCompany = $company->find($changed['company_id']['old']);
            $oldCompanyName = $oldCompany->name ?? trans('admin/companies/message.deleted');

            $newCompany = $company->find($changed['company_id']['new']);
            $newCompanyName = $newCompany->name ?? trans('admin/companies/message.deleted');

            $changed['company_id']['old'] = $changed['company_id']['old'] ? "[id: ".$changed['company_id']['old']."] ". $oldCompanyName : trans('general.unassigned');
            $changed['company_id']['new'] = $changed['company_id']['new'] ? "[id: ".$changed['company_id']['new']."] ". $newCompanyName : trans('general.unassigned');
            $changed['Company'] = $changed['company_id'];
            unset($changed['company_id']);
        }
        if(array_key_exists('supplier_id', $changed)) {

            $oldSupplier = $supplier->find($changed['supplier_id']['old']);
            $oldSupplierName = $oldSupplier->name ?? trans('admin/suppliers/message.deleted');

            $newSupplier = $supplier->find($changed['supplier_id']['new']);
            $newSupplierName = $newSupplier->name ?? trans('admin/suppliers/message.deleted');

            $changed['supplier_id']['old'] = $changed['supplier_id']['old'] ? "[id: ".$changed['supplier_id']['old']."] ". $oldSupplierName : trans('general.unassigned');
            $changed['supplier_id']['new'] = $changed['supplier_id']['new'] ? "[id: ".$changed['supplier_id']['new']."] ". $newSupplierName : trans('general.unassigned');
            $changed['Supplier'] = $changed['supplier_id'];
            unset($changed['supplier_id']);
        }
        if(array_key_exists('asset_eol_date', $changed)) {
            $changed['EOL date'] = $changed['asset_eol_date'];
            unset($changed['asset_eol_date']);
        }

        return $changed;

    }
}
