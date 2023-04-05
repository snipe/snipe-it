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

class LicenseWebhookTest extends TestCase
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

        event(new CheckoutableCheckedOut(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutLicenseSeatNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    /** @dataProvider checkoutTargets */
    public function testWebhookNotificationsAreNotSentOnLicenseCheckoutWhenWebhookSettingNotEnabled($checkoutTarget)
    {
        Notification::fake();

        Setting::factory()->withWebhookDisabled()->create();

        event(new CheckoutableCheckedOut(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutLicenseSeatNotification::class);
    }
}
