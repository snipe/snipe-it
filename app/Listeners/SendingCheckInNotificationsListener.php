<?php

namespace App\Listeners;

use App\Models\Recipients\AdminRecipient;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckinAssetNotification;
use App\Notifications\CheckinLicenseNotification;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseNotification;
use Illuminate\Support\Facades\Notification;

class SendingCheckInNotificationsListener
{
    /**
     * Notify the user about the checked in accessory
     */    
    public function onAccessoryCheckedIn($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckinAccessoryNotification($event->accessory, $event->checkedOutTo, $event->checkedInBy, $event->note)
        );
    }

    /**
     * Notify the user about the checked in asset
     */   
    public function onAssetCheckedIn($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckinAssetNotification($event->asset, $event->checkedOutTo, $event->checkedInBy, $event->note)
        );
    }   

    /**
     * Notify the user about the checked in license
     */   
    public function onLicenseCheckedIn($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckinLicenseNotification($event->license, $event->checkedOutTo, $event->checkedInBy, $event->note)
        );
    }   

    /**
     * Gets the entities to be notified of the passed event
     * 
     * @param  Event $event
     * @return Collection
     */
    private function getNotifiables($event) {
        $notifiables = collect();

        /**
         * Notify the user who checked out the item
         */
        $notifiables->push($event->checkedOutTo);

        /**
         * Notify Admin users if the settings is activated
         */
        if (Setting::getSettings()->admin_cc_email != '') {
            $notifiables->push(new AdminRecipient());
        }

        return $notifiables;       
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\AccessoryCheckedIn',
            'App\Listeners\SendingCheckInNotificationsListener@onAccessoryCheckedIn'
        ); 

        $events->listen(
            'App\Events\AssetCheckedIn',
            'App\Listeners\SendingCheckInNotificationsListener@onAssetCheckedIn'
        ); 

        $events->listen(
            'App\Events\LicenseCheckedIn',
            'App\Listeners\SendingCheckInNotificationsListener@onLicenseCheckedIn'
        );         
    }

}