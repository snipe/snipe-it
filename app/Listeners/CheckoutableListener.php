<?php

namespace App\Listeners;

use App\Events\CheckoutableCheckedOut;
use App\Mail\CheckinAccessoryMail;
use App\Mail\CheckinLicenseMail;
use App\Mail\CheckoutAccessoryMail;
use App\Mail\CheckoutAssetMail;
use App\Mail\CheckinAssetMail;
use App\Mail\CheckoutConsumableMail;
use App\Mail\CheckoutLicenseMail;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckinAssetNotification;
use App\Notifications\CheckinLicenseSeatNotification;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseSeatNotification;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Osama\LaravelTeamsNotification\TeamsNotification;

class CheckoutableListener
{
    private array $skipNotificationsFor = [
        Component::class,
    ];

    /**
     * Notify the user and post to webhook about the checked out checkoutable
     * and add a record to the checkout_requests table.
     */
    public function onCheckedOut($event)
    {
        if ($this->shouldNotSendAnyNotifications($event->checkoutable)) {
            return;
        }

        /**
         * Make a checkout acceptance and attach it in the notification
         */
        $settings = Setting::getSettings();
        $acceptance = $this->getCheckoutAcceptance($event);
        $adminCcEmailsArray = [];

        if ($settings->admin_cc_email !== '') {
            $adminCcEmail = $settings->admin_cc_email;
            $adminCcEmailsArray = array_map('trim', explode(',', $adminCcEmail));
        }
        $ccEmails = array_filter($adminCcEmailsArray);
        $mailable = $this->getCheckoutMailType($event, $acceptance);
        $notifiable = $this->getNotifiables($event);

        if ($event->checkedOutTo->locale) {
            $mailable->locale($event->checkedOutTo->locale);
        }
        // Send email notifications
        try {
            /**
             * Send an email if any of the following conditions are met:
             * 1. The asset requires acceptance
             * 2. The item has a EULA
             * 3. The item should send an email at check-in/check-out
             */

            if ($event->checkoutable->requireAcceptance() || $event->checkoutable->getEula() ||
                $this->checkoutableShouldSendEmail($event)) {
                Log::info('Sending checkout email, Locale: ' . ($event->checkedOutTo->locale ?? 'default'));
                if (!empty($notifiable)) {
                    Mail::to($notifiable)->cc($ccEmails)->send($mailable);
                } elseif (!empty($ccEmails)) {
                    Mail::cc($ccEmails)->send($mailable);
                }
                Log::info('Checkout Mail sent.');
            }
        } catch (ClientException $e) {
            Log::debug("Exception caught during checkout email: " . $e->getMessage());
        } catch (Exception $e) {
            Log::debug("Exception caught during checkout email: " . $e->getMessage());
        }
//                 Send Webhook notification
        try {
            if ($this->shouldSendWebhookNotification()) {
                if ($this->newMicrosoftTeamsWebhookEnabled()) {
                    $message = $this->getCheckoutNotification($event)->toMicrosoftTeams();
                    $notification = new TeamsNotification(Setting::getSettings()->webhook_endpoint);
                    $notification->success()->sendMessage($message[0], $message[1]);  // Send the message to Microsoft Teams
                } else {

                    Notification::route($this->webhookSelected(), Setting::getSettings()->webhook_endpoint)
                        ->notify($this->getCheckoutNotification($event, $acceptance));
                }
            }
        } catch (ClientException $e) {
            Log::error("ClientException caught during checkin notification: " . $e->getMessage());
            return redirect()->back()->with('warning', ucfirst(Setting::getSettings()->webhook_selected) .trans('admin/settings/message.webhook.webhook_fail') );
        } catch (Exception $e) {
            Log::error(ucfirst(Setting::getSettings()->webhook_selected) . ' webhook notification failed:', [
                'error' => $e->getMessage(),
                'webhook_endpoint' => Setting::getSettings()->webhook_endpoint,
                'event' => $event,
            ]);
            return redirect()->back()->with('warning', ucfirst(Setting::getSettings()->webhook_selected) . trans('admin/settings/message.webhook.webhook_fail'));
        }
    }




    /**
     * Notify the user and post to webhook about the checked in checkoutable
     */    
    public function onCheckedIn($event)
    {
        Log::debug('onCheckedIn in the Checkoutable listener fired');

        if ($this->shouldNotSendAnyNotifications($event->checkoutable)) {
            return;
        }

        /**
         * Send the appropriate notification
         */
        if ($event->checkedOutTo && $event->checkoutable){
            $acceptances = CheckoutAcceptance::where('checkoutable_id', $event->checkoutable->id)
                                            ->where('assigned_to_id', $event->checkedOutTo->id)
                                            ->get();

            foreach($acceptances as $acceptance){
                if($acceptance->isPending()){
                    $acceptance->delete();
                }
            }
        }
        $settings = Setting::getSettings();
        $adminCcEmailsArray = [];

        if($settings->admin_cc_email !== '') {
            $adminCcEmail = $settings->admin_cc_email;
            $adminCcEmailsArray = array_map('trim', explode(',', $adminCcEmail));
        }
        $ccEmails = array_filter($adminCcEmailsArray);
        $mailable =  $this->getCheckinMailType($event);
        $notifiable = $this->getNotifiables($event);
        if  ($event->checkedOutTo->locale){
            $mailable->locale($event->checkedOutTo->locale);
        }
        // Send email notifications
        try {
            /**
             * Send an email if any of the following conditions are met:
             * 1. The asset requires acceptance
             * 2. The item has a EULA
             * 3. The item should send an email at check-in/check-out
             */
                if ($event->checkoutable->requireAcceptance() || $event->checkoutable->getEula() ||
                    $this->checkoutableShouldSendEmail($event)) {
                    Log::info('Sending checkin email, Locale: ' . ($event->checkedOutTo->locale ?? 'default'));
                    if (!empty($notifiable)) {
                        Mail::to($notifiable)->cc($ccEmails)->send($mailable);
                    } elseif (!empty($ccEmails)){
                        Mail::cc($ccEmails)->send($mailable);
                    }
                    Log::info('Checkin Mail sent.');
                }
        } catch (ClientException $e) {
            Log::debug("Exception caught during checkin email: " . $e->getMessage());
        } catch (Exception $e) {
            Log::debug("Exception caught during checkin email: " . $e->getMessage());
        }

        // Send Webhook notification
        try {
            if ($this->shouldSendWebhookNotification()) {
                if ($this->newMicrosoftTeamsWebhookEnabled()) {
                    $message = $this->getCheckinNotification($event)->toMicrosoftTeams();
                    $notification = new TeamsNotification(Setting::getSettings()->webhook_endpoint);
                    $notification->success()->sendMessage($message[0], $message[1]); // Send the message to Microsoft Teams
                } else {
                    Notification::route($this->webhookSelected(), Setting::getSettings()->webhook_endpoint)
                        ->notify($this->getCheckinNotification($event));
                }
            }
        } catch (ClientException $e) {
            Log::error("ClientException caught during checkin notification: " . $e->getMessage());
            return redirect()->back()->with('warning', ucfirst(Setting::getSettings()->webhook_selected) .trans('admin/settings/message.webhook.webhook_fail'));
        } catch (Exception $e) {
            Log::error(ucfirst(Setting::getSettings()->webhook_selected) . ' webhook notification failed:', [
                'error' => $e->getMessage(),
                'webhook_endpoint' => Setting::getSettings()->webhook_endpoint,
                'event' => $event,
            ]);
            return redirect()->back()->with('warning', ucfirst(Setting::getSettings()->webhook_selected) .trans('admin/settings/message.webhook.webhook_fail'));
        }
    }      

    /**
     * Generates a checkout acceptance
     * @param  Event $event
     * @return mixed
     */
    private function getCheckoutAcceptance($event)
    {
        $checkedOutToType = get_class($event->checkedOutTo);
        if ($checkedOutToType != "App\Models\User") {
            return null;
        }
        if (!$event->checkoutable->requireAcceptance()) {
            return null;
        }

        $acceptance = new CheckoutAcceptance;
        $acceptance->checkoutable()->associate($event->checkoutable);
        $acceptance->assignedTo()->associate($event->checkedOutTo);
        $acceptance->save();

        return $acceptance;      
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

        Log::debug('Notification class: '.$notificationClass);

        return new $notificationClass($event->checkoutable, $event->checkedOutTo, $event->checkedInBy, $event->note);  
    }

    /**
     * Get the appropriate notification for the event
     * 
     * @param  CheckoutableCheckedOut $event
     * @param  CheckoutAcceptance|null $acceptance
     * @return Notification
     */
    private function getCheckoutNotification($event, $acceptance = null)
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
    private function getCheckoutMailType($event, $acceptance){
        $lookup = [
            Accessory::class => CheckoutAccessoryMail::class,
            Asset::class => CheckoutAssetMail::class,
            LicenseSeat::class => CheckoutLicenseMail::class,
            Consumable::class => CheckoutConsumableMail::class,
        ];
        $mailable= $lookup[get_class($event->checkoutable)];

        return new $mailable($event->checkoutable, $event->checkedOutTo, $event->checkedOutBy, $acceptance, $event->note);

    }
    private function getCheckinMailType($event){
        $lookup = [
            Accessory::class => CheckinAccessoryMail::class,
            Asset::class => CheckinAssetMail::class,
            LicenseSeat::class => CheckinLicenseMail::class,
        ];

        $mailable= $lookup[get_class($event->checkoutable)];

        return new $mailable($event->checkoutable, $event->checkedOutTo, $event->checkedInBy, $event->note);

    }
    private function getNotifiables($event){

        if($event->checkedOutTo instanceof Asset){
            $event->checkedOutTo->load('assignedTo');
            return $event->checkedOutTo->assignedto?->email ?? '';
        }
        else if($event->checkedOutTo instanceof Location) {
            return $event->checkedOutTo->manager?->email ?? '';
        }
        else{
            return $event->checkedOutTo?->email ?? '';
        }
    }
    private function webhookSelected(){
        if(Setting::getSettings()->webhook_selected === 'slack' || Setting::getSettings()->webhook_selected === 'general'){
            return 'slack';
        }

        return Setting::getSettings()->webhook_selected;
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

    private function shouldNotSendAnyNotifications($checkoutable): bool
    {
        return in_array(get_class($checkoutable), $this->skipNotificationsFor);
    }

    private function shouldSendWebhookNotification(): bool
    {
        return Setting::getSettings() && Setting::getSettings()->webhook_endpoint;
    }

    private function checkoutableShouldSendEmail($event): bool
    {
        if($event->checkoutable instanceof LicenseSeat){
            return $event->checkoutable->license->checkin_email();
        }
        return (method_exists($event->checkoutable, 'checkin_email') && $event->checkoutable->checkin_email());
    }

    private function newMicrosoftTeamsWebhookEnabled(): bool
    {
        return Setting::getSettings()->webhook_selected === 'microsoft' && Str::contains(Setting::getSettings()->webhook_endpoint, 'workflows');
    }
}
