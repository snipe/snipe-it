<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssetObserver
{

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
            $prefix = (string)($settings->auto_increment_prefix ?? '');
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
                if ($next_asset_tag > $settings->next_auto_tag_base && $next_asset_tag < PHP_INT_MAX) {
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
        $logAction->created_by = auth()->id();
        if($asset->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('create');
    }



    /**
     * Executes every time an asset is saved.
     *
     * This matters specifically because any database fields affected here MUST already exist on
     * the assets table (and/or any related models), or related migrations WILL fail.
     *
     * For example, if there is a database migration that's a bit older and modifies an asset, if the save
     * fires before a field gets created in a later migration and that field in the later migration
     * is used in this observer, it doesn't actually exist yet and the migration will break unless we
     * use saveQuietly() in the migration which skips this observer.
     *
     * @see https://github.com/snipe/snipe-it/issues/13723#issuecomment-1761315938
     */
    public function saving(Asset $asset)
    {
        // determine if calculated eol and then calculate it - this should only happen on a new asset
        if (is_null($asset->asset_eol_date) && !is_null($asset->purchase_date) && ($asset->model->eol > 0)){
            $asset->asset_eol_date = $asset->purchase_date->addMonths($asset->model->eol)->format('Y-m-d');
            $asset->eol_explicit = false; 
        } 

       // determine if explicit and set eol_explicit to true
       if (!is_null($asset->asset_eol_date) && !is_null($asset->purchase_date)) {
            if($asset->model->eol > 0) {
                $months = Carbon::parse($asset->asset_eol_date)->diffInMonths($asset->purchase_date); 
                if($months != $asset->model->eol) {
                    $asset->eol_explicit = true;
                }
            }
       } elseif (!is_null($asset->asset_eol_date) && is_null($asset->purchase_date)) {
           $asset->eol_explicit = true;
       }
       if ((!is_null($asset->asset_eol_date)) && (!is_null($asset->purchase_date)) && (is_null($asset->model->eol) || ($asset->model->eol == 0))) {
           $asset->eol_explicit = true;
       }

    }
}
