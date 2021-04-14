<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\Setting;
use App\Models\Actionlog;
use App\Models\Statuslabel;
use Auth;
use Log;
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
        $status_review_wait = Statuslabel::where('name', 'Ожидает проверки')->first();
        $status_inventory_wait = Statuslabel::where('name', 'Ожидает инвентаризации')->first();
        $status_ok = Statuslabel::where('name', 'Доступные')->first();
        // если все активы из закупки провверены то закупка окончена
        if($asset->purchase && $asset->getOriginal()['status_id'] == $status_review_wait->id){
            Log::error('An informational message.$status_review_wait');
            $purchase=$asset->purchase;
            $assets=$purchase->assets;
            $all_ok1 = true;
            foreach ($assets as &$as1) {
                if ($as1->status_id == $status_ok->id || $as1->id ==$asset->id ){
                }else{
                    $all_ok1 = false;
                }

            }
            if($all_ok1){
                $purchase->status="finished";
                $purchase->save();
            }
        }
        // если все активы из закупки инвентаризированиа  то закупка уходит на прверку
//        if($asset->purchase && $asset->purchase->status == "inventory"  && $asset->getOriginal()['status_id']==$status_inventory_wait->id){
        if($asset->purchase && $asset->getOriginal()['status_id'] == $status_inventory_wait->id){
            $purchase = $asset->purchase;
            $assets= $purchase->assets;
            $all_ok2 = true;
            foreach ($assets as &$as2) {
                if ($as2->status_id == $status_review_wait->id || $as2->id ==$asset->id ){

                }else{
                    $all_ok2 = false;
                }

            }
            if($all_ok2){
                $purchase->status="review";
                $purchase->save();
            }
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
