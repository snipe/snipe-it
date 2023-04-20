<?php

namespace Tests\Feature\Notifications;

use App\Events\CheckoutableCheckedIn;
use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\LicenseSeat;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckinLicenseSeatNotification;
use App\Notifications\CheckoutLicenseSeatNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class LicenseWebhookTest extends TestCase
{
    use InteractsWithSettings;

    public function targets(): array
    {
        return [
            'License checked out to user' => [fn() => User::factory()->create()],
            'License checked out to asset' => [fn() => Asset::factory()->laptopMbp()->create()],
        ];
    }

    /** @dataProvider targets */
    public function testLicenseCheckoutSendsWebhookNotificationWhenSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->enableWebhook();

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

    /** @dataProvider targets */
    public function testLicenseCheckoutDoesNotSendWebhookNotificationWhenSettingDisabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->disableWebhook();

        event(new CheckoutableCheckedOut(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutLicenseSeatNotification::class);
    }

    /** @dataProvider targets */
    public function testLicenseCheckinSendsWebhookNotificationWhenSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->enableWebhook();

        event(new CheckoutableCheckedIn(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckinLicenseSeatNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    /** @dataProvider targets */
    public function testLicenseCheckinDoesNotSendWebhookNotificationWhenSettingDisabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->disableWebhook();

        event(new CheckoutableCheckedIn(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinLicenseSeatNotification::class);
    }
}
