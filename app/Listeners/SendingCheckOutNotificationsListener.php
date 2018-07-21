<?php

namespace App\Listeners;

use App\Models\Recipients\AdminRecipient;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseNotification;

class SendingCheckOutNotificationsListener
{
    /**
     * Handle user login events.
     */
    public function onConsumableCheckedOut($event) {
        /**
         * Notify the user about the checked out consumable
         */
        $this->sendNotification(CheckoutConsumableNotification::class, $event->logEntry);       
    }

    public function onAccessoryCheckedOut($event) {
        /**
         * Notify the user about the checked out accessory
         */
        $this->sendNotification(CheckoutAccessoryNotification::class, $event->logEntry);
    }

    public function onLicenseCheckedOut($event) {
        /**
         * Notify the user about the checked out license
         */
        $this->sendNotification(CheckoutLicenseNotification::class, $event->logEntry);
    }   

    public function onAssetCheckedOut($event) {
        /**
         * Notify the user about the checked out asset
         */
        $this->sendNotification(CheckoutAssetNotification::class, $event->logEntry);
    }   

    private function sendNotification($notificationClass, $logEntry) {
        /**
         * When the item isn't checked out to a user, we can't send notifications
         */
        if(! $logEntry->target instanceof User) {
            return;
        }

        $params = [
            'log_id'      => $logEntry->id,            
            'item'        => $logEntry->item,
            'target_type' => $logEntry->target_type,
            'admin'       => $logEntry->user,

            'target'   => $logEntry->target,
            'note'     => $logEntry->note,
            'settings' => Setting::getSettings(),
        ];

        $logEntry->target->notify(new $notificationClass($params));

        /**
         * Notify Admin users if the settings is activated
         */
        if (Setting::getSettings()->admin_cc_email != '') {
            $recipient = new AdminRecipient();

            $recipient->notify(new $notificationClass($params));
        }         
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