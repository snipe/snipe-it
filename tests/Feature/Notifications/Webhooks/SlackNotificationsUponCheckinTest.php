<?php

namespace Tests\Feature\Notifications\Webhooks;

use App\Events\CheckoutableCheckedIn;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckinAssetNotification;
use App\Notifications\CheckinLicenseSeatNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class SlackNotificationsUponCheckinTest extends TestCase
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

    public function testAccessoryCheckinSendsSlackNotificationWhenSettingEnabled()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedIn(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckinAccessoryNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testAccessoryCheckinDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedIn(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinAccessoryNotification::class);
    }

    /** @dataProvider assetCheckoutTargets */
    public function testAssetCheckinSendsSlackNotificationWhenSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedIn(
            Asset::factory()->laptopMbp()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckinAssetNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    /** @dataProvider assetCheckoutTargets */
    public function testAssetCheckinDoesNotSendSlackNotificationWhenSettingDisabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedIn(
            Asset::factory()->laptopMbp()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinAssetNotification::class);
    }

    public function testComponentCheckinDoesNotSendSlackNotification()
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

        event(new CheckoutableCheckedIn(
            Component::factory()->ramCrucial8()->create(),
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNothingSent();
    }

    public function testConsumableCheckinSendSlackNotificationWhenSettingEnabled()
    {
        $this->markTestIncomplete();
    }

    public function testConsumableCheckinDoesNotSendSlackNotificationWhenSettingDisabled()
    {
        $this->markTestIncomplete();
    }

    /** @dataProvider licenseCheckoutTargets */
    public function testLicenseCheckinSendsSlackNotificationWhenSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->enableSlackWebhook();

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

    /** @dataProvider licenseCheckoutTargets */
    public function testLicenseCheckinDoesNotSendSlackNotificationWhenSettingDisabled($checkoutTarget)
    {
        Notification::fake();

        $this->settings->disableSlackWebhook();

        event(new CheckoutableCheckedIn(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinLicenseSeatNotification::class);
    }
}
