<?php

namespace App\Listeners;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Consumable;
use App\Models\LicenseSeat;
use App\Models\Recipients\AdminRecipient;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\BulkCheckoutAssetNotification;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckinAssetNotification;
use App\Notifications\CheckinLicenseNotification;
use App\Notifications\CheckinLicenseSeatNotification;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseNotification;
use App\Notifications\CheckoutLicenseSeatNotification;
use Illuminate\Support\Facades\Notification;
use mysql_xdevapi\Exception;

class CheckoutableListener
{

    /**
     * Notify the user about the checked out checkoutable
     */
    public function onCheckedOut($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(! $event->checkedOutTo instanceof User || ($event->isIndividual && $event->isBulkCheckoutEmail)) {
            return;
        }

        /**
         * Make a checkout acceptance and attach it in the notification
         */
        $isBulkCheckoutEmail = $this->isBulkCheckoutEmail($event);
        $acceptance = $this->getCheckoutAcceptance($event, $isBulkCheckoutEmail);

        if(!$event->checkedOutTo->locale){
            Notification::locale(Setting::getSettings()->locale)->send(
                $this->getNotifiables($event),
                $this->getCheckoutNotification($event, $acceptance, $isBulkCheckoutEmail)
            );
        } else {
            Notification::send(
                $this->getNotifiables($event),
                $this->getCheckoutNotification($event, $acceptance, $isBulkCheckoutEmail)
            );
        }
    }

    /**
     * Notify the user about the checked in checkoutable
     */    
    public function onCheckedIn($event) {
        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if(!$event->checkedOutTo instanceof User) {
            return;
        }

        /**
         * Send the appropriate notification
         */
        if(!$event->checkedOutTo->locale){
            Notification::locale(Setting::getSettings()->locale)->send(
                $this->getNotifiables($event), 
                $this->getCheckinNotification($event)
            );
        } else {
            Notification::send(
                $this->getNotifiables($event), 
                $this->getCheckinNotification($event)
            );
        }
    }

    private function getAssetAcceptance($asset, $checkedOutTo) {
        if (!$asset->requireAcceptance()) {
            return null;
        }

        $acceptance = new CheckoutAcceptance;
        $acceptance->checkoutable()->associate($asset);
        $acceptance->assignedTo()->associate($checkedOutTo);
        $acceptance->save();

        return $acceptance;
    }

    /**
     * Generates a checkout acceptance
     * @param  Event $event
     * @return mixed
     */
    private function getCheckoutAcceptance($event, $isBulkCheckoutEmail) {
        if ($isBulkCheckoutEmail) {
            return null;
        }

        return $this->getAssetAcceptance($event->checkoutable, $event->checkedOutTo);
    }

    /**
     * @param Event $event
     * @return boolean
     */
    private function isBulkCheckoutEmail($event)
    {
        return $event->isBulkCheckoutEmail;
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
     * Get the appropriate notification for the event
     * 
     * @param  CheckoutableCheckedIn $event 
     * @return Notification
     */
    private function getCheckinNotification($event) {

        $model = get_class($event->checkoutable);

        $notificationClass = null;

        switch (get_class($event->checkoutable)) {
            case Accessory::class:
                $notificationClass = CheckinAccessoryNotification::class;
                break;
            case Asset::class:
                $notificationClass = CheckinAssetNotification::class;
                break;    
            case LicenseSeat::class:
                $notificationClass = CheckinLicenseSeatNotification::class;
                break;
        }
 
        return new $notificationClass($event->checkoutable, $event->checkedOutTo, $event->checkedInBy, $event->note);  
    }

    /**
     * Get the appropriate notification for the event
     * 
     * @param  CheckoutableCheckedIn $event 
     * @param  CheckoutAcceptance $acceptance 
     * @return Notification
     */
    private function getCheckoutNotification($event, $acceptance, $isBulkCheckoutEmail) {
        $notificationClass = null;
        $checkOutDate = isset($event->dates) ? $event->dates["checkout"] : null;
        $checkInDate = isset($event->dates) ? $event->dates["checkin"] : null;
        if ($isBulkCheckoutEmail) {
            $notificationClass = BulkCheckoutAssetNotification::class;
        }else {
            switch (get_class($event->checkoutable)) {
                case Accessory::class:
                    $notificationClass = CheckoutAccessoryNotification::class;
                    break;
                case Asset::class:
                    $notificationClass = CheckoutAssetNotification::class;
                    break;
                case Consumable::class:
                    $notificationClass = CheckoutConsumableNotification::class;
                    break;
                case LicenseSeat::class:
                    $notificationClass = CheckoutLicenseSeatNotification::class;
                    break;
            }
        }

        return new $notificationClass($event->checkoutable, $event->checkedOutTo, $event->checkedOutBy, $acceptance, $event->note, $checkOutDate, $checkInDate);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\CheckoutableCheckedIn',
            'App\Listeners\CheckoutableListener@onCheckedIn'
        );

        $events->listen(
            'App\Events\CheckoutableCheckedOut',
            'App\Listeners\CheckoutableListener@onCheckedOut'
        ); 
    }

}