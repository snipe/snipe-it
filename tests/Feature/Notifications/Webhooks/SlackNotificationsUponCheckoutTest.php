<?php

namespace Tests\Feature\Notifications\Webhooks;

use App\Events\CheckoutableCheckedOut;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseSeatNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class SlackNotificationsUponCheckoutTest extends TestCase
{
    use InteractsWithSettings;

    public function assetCheckoutTargets(): array
    {
        return [
            'Asset checked out to user' => [fn() => User::factory()->create()],
            'Asset checked out to asset' => [fn() => Asset::factory()->laptopMbp()->create()],
            'Asset checked out to location' => [fn() => Location::factory()->create()],
        ];
    }

    public function licenseCheckoutTargets(): array
    {
        return [
            'License checked out to user' => [fn() => User::factory()->create()],
            'License checked out to asset' => [fn() => Asset::factory()->laptopMbp()->create()],
        ];
    }

    public function testAccessoryCheckoutSendsSlackNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutAccessoryNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testAccessoryCheckoutDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutAccessoryNotification::class);
    }

    /** @dataProvider assetCheckoutTargets */
    public function testAssetCheckoutSendsSlackNotificationWhenSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Asset::factory()->laptopMbp()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    /** @dataProvider assetCheckoutTargets */
    public function testAssetCheckoutDoesNotSendSlackNotificationWhenSettingDisabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Asset::factory()->laptopMbp()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutAssetNotification::class);
    }

    public function testComponentCheckoutDoesNotSendSlackNotification()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Component::factory()->ramCrucial8()->create(),
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNothingSent();
    }

    public function testConsumableCheckoutSendsSlackNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Consumable::factory()->cardstock()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutConsumableNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testConsumableCheckoutDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedOut(
            Consumable::factory()->cardstock()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutConsumableNotification::class);
    }

    /** @dataProvider licenseCheckoutTargets */
    public function testLicenseCheckoutSendsSlackNotificationWhenSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

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

    /** @dataProvider licenseCheckoutTargets */
    public function testLicenseCheckoutDoesNotSendSlackNotificationWhenSettingDisabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedOut(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutLicenseSeatNotification::class);
    }
}
