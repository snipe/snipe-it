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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class SlackNotificationsUponCheckinTest extends TestCase
{
    use InteractsWithSettings;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

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
        $this->settings->enableSlackWebhook();

        $this->fireCheckInEvent(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
        );

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
        $this->settings->disableSlackWebhook();

        $this->fireCheckInEvent(
            Accessory::factory()->appleBtKeyboard()->create(),
            User::factory()->create(),
        );

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinAccessoryNotification::class);
    }

    /** @dataProvider assetCheckoutTargets */
    public function testAssetCheckinSendsSlackNotificationWhenSettingEnabled($checkoutTarget)
    {
        $this->settings->enableSlackWebhook();

        $this->fireCheckInEvent(
            Asset::factory()->laptopMbp()->create(),
            $checkoutTarget(),
        );

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
        $this->settings->disableSlackWebhook();

        $this->fireCheckInEvent(
            Asset::factory()->laptopMbp()->create(),
            $checkoutTarget(),
        );

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinAssetNotification::class);
    }

    public function testComponentCheckinDoesNotSendSlackNotification()
    {
        $this->settings->enableSlackWebhook();

        $this->fireCheckInEvent(
            Component::factory()->ramCrucial8()->create(),
            Asset::factory()->laptopMbp()->create(),
        );

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
        $this->settings->enableSlackWebhook();

        $this->fireCheckInEvent(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
        );

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
        $this->settings->disableSlackWebhook();

        $this->fireCheckInEvent(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
        );

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckinLicenseSeatNotification::class);
    }

    private function fireCheckInEvent(Model $checkoutable, Model $target)
    {
        event(new CheckoutableCheckedIn(
            $checkoutable,
            $target,
            User::factory()->superuser()->create(),
            ''
        ));
    }
}
