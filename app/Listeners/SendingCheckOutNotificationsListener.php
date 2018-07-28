<?php

namespace App\Listeners;

use App\Models\CheckoutAcceptance;
use App\Models\Recipients\AdminRecipient;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseNotification;
use App\Notifications\CheckoutLicenseSeatNotification;
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

        /**
         * Make a checkout acceptance and attach it in the notification
         */
        $acceptance = null;
        if ($event->consumable->requireAcceptance()) {
            $acceptance = new CheckoutAcceptance;
            $acceptance->checkoutable()->associate($event->consumable);
            $acceptance->assignedTo()->associate($event->checkedOutTo);
            $acceptance->save();
        }

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutConsumableNotification($event->consumable, $event->checkedOutTo, $event->checkedOutBy, $acceptance, $event->note)
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

        /**
         * Make a checkout acceptance and attach it in the notification
         */
        $acceptance = null;
        if ($event->accessory->requireAcceptance()) {
            $acceptance = new CheckoutAcceptance;
            $acceptance->checkoutable()->associate($event->accessory);
            $acceptance->assignedTo()->associate($event->checkedOutTo);
            $acceptance->save();
        }        

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutAccessoryNotification($event->accessory, $event->checkedOutTo, $event->checkedOutBy, $acceptance, $event->note)
        );
    }

    /**
     * Notify the user about the checked out license
     */
    public function onLicenseSeatCheckedOut($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User) {
            return;
        }

        /**
         * Make a checkout acceptance and attach it in the notification
         */
        $acceptance = null;
        if ($event->licenseSeat->license->requireAcceptance()) {
            $acceptance = new CheckoutAcceptance;
            $acceptance->checkoutable()->associate($event->licenseSeat);
            $acceptance->assignedTo()->associate($event->checkedOutTo);
            $acceptance->save();
        }    

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutLicenseSeatNotification($event->licenseSeat, $event->checkedOutTo, $event->checkedOutBy, $acceptance, $event->note)
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

        /**
         * Make a checkout acceptance and attach it in the notification
         */
        $acceptance = null;
        if ($event->asset->requireAcceptance()) {
            $acceptance = new CheckoutAcceptance;
            $acceptance->checkoutable()->associate($event->asset);
            $acceptance->assignedTo()->associate($event->checkedOutTo);
            $acceptance->save();
        }         

        Notification::send(
            $this->getNotifiables($event), 
            new CheckoutAssetNotification($event->asset, $event->checkedOutTo, $event->checkedOutBy, $acceptance, $event->note)
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
            'App\Events\LicenseSeatCheckedOut',
            'App\Listeners\SendingCheckOutNotificationsListener@onLicenseSeatCheckedOut'
        ); 

        $events->listen(
            'App\Events\AssetCheckedOut',
            'App\Listeners\SendingCheckOutNotificationsListener@onAssetCheckedOut'
        );         
    }

}