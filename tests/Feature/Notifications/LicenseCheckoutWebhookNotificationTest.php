<?php

namespace Tests\Feature\Notifications;

use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\LicenseSeat;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutLicenseSeatNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LicenseCheckoutWebhookNotificationTest extends TestCase
{
    public function checkoutTargets()
    {
        return [
            'License checked out to user' => [fn() => User::factory()->create()],
            'License checked out to asset' => [fn() => Asset::factory()->laptopMbp()->create()],
        ];
    }

    /** @dataProvider checkoutTargets */
    public function testWebhookNotificationsAreSentOnLicenseCheckoutWhenWebhookSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        Setting::factory()->withWebhookEnabled()->create();

        $checkoutTarget = $checkoutTarget();
        
        $licenseSeat = LicenseSeat::factory()->create();

        // @todo: this has to go through the LicenseCheckoutController::store() method
        // @todo: to have the CheckoutableCheckedOut fire...
        // @todo: either change this to go through controller
        // @todo: or move that functionality to the model?
        // $licenseSeat->checkOut(
        //     $checkoutTarget,
        //     User::factory()->superuser()->create()->id
        // );

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutLicenseSeatNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }
}
