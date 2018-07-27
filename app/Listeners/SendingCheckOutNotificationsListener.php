<?php

namespace App\Listeners;

use App\Models\Recipients\AdminRecipient;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseNotification;
use Illuminate\Support\Facades\Notification;

class SendingCheckOutNotificationsListener
{
    /**
     * Notify the user about the checked out consumable
     */
    public function onConsumableCheckedOut($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutConsumableNotification($event->consumable, $event->checkedOutTo, $event->checkedOutBy, $event->note)
        );
    }
    
    /**
     * Notify the user about the checked out accessory
     */
    public function onAccessoryCheckedOut($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutAccessoryNotification($event->accessory, $event->checkedOutTo, $event->checkedOutBy, $event->note)
        );
    }

    /**
     * Notify the user about the checked out license
     */
    public function onLicenseCheckedOut($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutLicenseNotification($event->license, $event->checkedOutTo, $event->checkedOutBy, $event->note)
        ); 
    }   
    
    /**
     * Notify the user about the checked out asset
     */
    public function onAssetCheckedOut($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutAssetNotification($event->asset, $event->checkedOutTo, $event->checkedOutBy, $event->note)
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
            'App\Events\ConsumableCheckedOut',
            'App\Listeners\SendingCheckOutNotificationsListener@onConsumableCheckedOut'
        );

        $events->listen(
            'App\Events\AccessoryCheckedOut',
            'App\Listeners\SendingCheckOutNotificationsListener@onAccessoryCheckedOut'
        ); 

        $events->listen(
            'App\Events\LicenseCheckedOut',
            'App\Listeners\SendingCheckOutNotificationsListener@onLicenseCheckedOut'
        ); 

        $events->listen(
            'App\Events\AssetCheckedOut',
            'App\Listeners\SendingCheckOutNotificationsListener@onAssetCheckedOut'
        );         
    }

}