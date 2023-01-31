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
use Exception;
use Log;

class CheckoutableListener
{
    /**
     * Notify the user about the checked out checkoutable and add a record to the
     * checkout_requests table.
     */
    public function onCheckedOut($event)
    {


        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if (! $event->checkedOutTo instanceof User) {
            return;
        }

        /**
         * Make a checkout acceptance and attach it in the notification
         */
        $acceptance = $this->getCheckoutAcceptance($event);       

        try {
            if (! $event->checkedOutTo->locale) {
                Notification::locale(Setting::getSettings()->locale)->send(
                    $this->getNotifiables($event),
                    $this->getCheckoutNotification($event, $acceptance)
                );
            } else {
                Notification::send(
                    $this->getNotifiables($event),
                    $this->getCheckoutNotification($event, $acceptance)
                );
            }
        } catch (Exception $e) {
            Log::error("Exception caught during checkout notification: ".$e->getMessage());
        }
    }

    /**
     * Notify the user about the checked in checkoutable
     */    
    public function onCheckedIn($event)
    {
        \Log::debug('onCheckedIn in the Checkoutable listener fired');

        /**
         * When the item wasn't checked out to a user, we can't send notifications
         */
        if (! $event->checkedOutTo instanceof User) {
            return;
        }

        /**
         * Send the appropriate notification
         */
        $acceptances = CheckoutAcceptance::where('checkoutable_id', $event->checkoutable->id)
                                        ->where('assigned_to_id', $event->checkedOutTo->id)
                                        ->get();

        foreach($acceptances as $acceptance){
            if($acceptance->isPending()){
                $acceptance->delete();
            }
        }

        try {
            // Use default locale
            if (! $event->checkedOutTo->locale) {
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
        } catch (Exception $e) {
            Log::error("Exception caught during checkin notification: ".$e->getMessage());
        }
    }      

    /**
     * Generates a checkout acceptance
     * @param  Event $event
     * @return mixed
     */
    private function getCheckoutAcceptance($event)
    {
        if (! $event->checkoutable->requireAcceptance()) {
            return null;
        }

        $acceptance = new CheckoutAcceptance;
        $acceptance->checkoutable()->associate($event->checkoutable);
        $acceptance->assignedTo()->associate($event->checkedOutTo);
        $acceptance->save();

        return $acceptance;      
    }

    /**
     * Gets the entities to be notified of the passed event
     * 
     * @param  Event $event
     * @return Collection
     */
    private function getNotifiables($event)
    {
        $notifiables = collect();

        /**
         * Notify the user who checked out the item
         */
        $notifiables->push($event->checkedOutTo);

        /**
         * Notify Admin users if the settings is activated
         */
        if ((Setting::getSettings()) && (Setting::getSettings()->admin_cc_email != '')) {
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
    private function getCheckinNotification($event)
    {

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

        \Log::debug('Notification class: '.$notificationClass);

        return new $notificationClass($event->checkoutable, $event->checkedOutTo, $event->checkedInBy, $event->note);  
    }

    /**
     * Get the appropriate notification for the event
     * 
     * @param  CheckoutableCheckedIn $event 
     * @param  CheckoutAcceptance $acceptance 
     * @return Notification
     */
    private function getCheckoutNotification($event, $acceptance)
    {
        $notificationClass = null;

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

        return new $notificationClass($event->checkoutable, $event->checkedOutTo, $event->checkedOutBy, $acceptance, $event->note);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\CheckoutableCheckedIn::class,
            'App\Listeners\CheckoutableListener@onCheckedIn'
        ); 

        $events->listen(
            \App\Events\CheckoutableCheckedOut::class,
            'App\Listeners\CheckoutableListener@onCheckedOut'
        ); 
    }
}
