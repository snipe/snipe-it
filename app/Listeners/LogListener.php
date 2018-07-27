<?php

namespace App\Listeners;

use App\Events\AccessoryCheckedIn;
use App\Events\AccessoryCheckedOut;
use App\Events\AssetCheckedIn;
use App\Events\AssetCheckedOut;
use App\Events\ComponentCheckedIn;
use App\Events\ComponentCheckedOut;
use App\Events\ConsumableCheckedOut;
use App\Events\LicenseCheckedIn;
use App\Events\LicenseCheckedOut;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Component;


class LogListener
{
    public function onAccessoryCheckedIn(AccessoryCheckedIn $event) {
        $event->accessory->logCheckin($event->checkedOutTo, $event->note);
    }

    public function onAccessoryCheckedOut(AccessoryCheckedOut $event) {
        $event->accessory->logCheckout($event->note, $event->checkedOutTo);
    }    

    public function onAssetCheckedIn(AssetCheckedIn $event) {
        $event->asset->logCheckin($event->checkedOutTo, $event->note);
    }    

    public function onAssetCheckedOut(AssetCheckedOut $event) {
        $event->asset->logCheckout($event->note, $event->checkedOutTo);
    }      

    public function onComponentCheckedIn(ComponentCheckedIn $event) {
            $log = new Actionlog();
            $log->user_id = $event->checkedInBy->id;
            $log->action_type = 'checkin from';
            $log->target_type = Asset::class;
            $log->target_id = $event->checkedOutTo->asset_id;
            $log->item_id = $event->checkedOutTo->component_id;
            $log->item_type = Component::class;
            $log->note = $event->note;
            $log->save();
    }

    public function onComponentCheckedOut(ComponentCheckedOut $event) {
        // Since components don't have a "note" field, submit empty note
        $event->component->logCheckout(null, $event->checkedOutTo);
    }         

    public function onConsumableCheckedOut(ConsumableCheckedOut $event) {
        $event->consumable->logCheckout($event->note, $event->checkedOutTo);
    } 

    public function onLicenseCheckedIn(LicenseCheckedIn $event) {
        $event->license->logCheckin($event->checkedOutTo, $event->note);
    }

    public function onLicenseCheckedOut(LicenseCheckedOut $event) {
        $event->license->logCheckout($event->note, $event->checkedOutTo);
    } 

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $list = [
            'AccessoryCheckedIn',
            'AccessoryCheckedOut',            
            'AssetCheckedIn',
            'AssetCheckedOut',
            'ComponentCheckedIn', 
            'ComponentCheckedOut',    
            'ConsumableCheckedOut',  
            'LicenseCheckedIn',
            'LicenseCheckedOut',  
        ];

        foreach($list as $event)  {
            $events->listen(
                'App\Events\\' . $event,
                'App\Listeners\LogListener@on' . $event
            );
        }         
    }

}