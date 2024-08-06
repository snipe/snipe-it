<?php

namespace Tests\Feature\Notifications\Webhooks;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use App\Events\CheckoutableCheckedOut;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\User;
use App\Notifications\CheckoutAccessoryNotification;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CheckoutConsumableNotification;
use App\Notifications\CheckoutLicenseSeatNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

#[Group('notifications')]
final class SlackNotificationsUponCheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public static function assetCheckoutTargets(): array
    {
        return [
            'Asset checked out to user' => [fn() => User::factory()->create()],
            'Asset checked out to asset' => [fn() => Asset::factory()->laptopMbp()->create()],
            'Asset checked out to location' => [fn() => Location::factory()->create()],
        ];
    }

    public static function licenseCheckoutTargets(): array
    {
        return [
            'License checked out to user' => [fn() => User::factory()->create()],
            'License checked out to asset' => [fn() => Asset::factory()->laptopMbp()->create()],
        ];
    }

    public function testAccessoryCheckoutSendsSlackNotificationWhenSettingEnabled(): void
    {
        $this->settings->enableSlackWebhook();

        $this->fireCheckOutEvent(
            Accessory::factory()->create(),
            User::factory()->create(),
        );

        $this->assertSlackNotificationSent(CheckoutAccessoryNotification::class);
    }

    public function testAccessoryCheckoutDoesNotSendSlackNotificationWhenSettingDisabled(): void
    {
        $this->settings->disableSlackWebhook();

        $this->fireCheckOutEvent(
            Accessory::factory()->create(),
            User::factory()->create(),
        );

        $this->assertNoSlackNotificationSent(CheckoutAccessoryNotification::class);
    }

    #[DataProvider('assetCheckoutTargets')]
    public function testAssetCheckoutSendsSlackNotificationWhenSettingEnabled($checkoutTarget): void
    {
        $this->settings->enableSlackWebhook();

        $this->fireCheckOutEvent(
            Asset::factory()->create(),
            $checkoutTarget(),
        );

        $this->assertSlackNotificationSent(CheckoutAssetNotification::class);
    }

    #[DataProvider('assetCheckoutTargets')]
    public function testAssetCheckoutDoesNotSendSlackNotificationWhenSettingDisabled($checkoutTarget): void
    {
        $this->settings->disableSlackWebhook();

        $this->fireCheckOutEvent(
            Asset::factory()->create(),
            $checkoutTarget(),
        );

        $this->assertNoSlackNotificationSent(CheckoutAssetNotification::class);
    }

    public function testComponentCheckoutDoesNotSendSlackNotification(): void
    {
        $this->settings->enableSlackWebhook();

        $this->fireCheckOutEvent(
            Component::factory()->create(),
            Asset::factory()->laptopMbp()->create(),
        );

        Notification::assertNothingSent();
    }

    public function testConsumableCheckoutSendsSlackNotificationWhenSettingEnabled(): void
    {
        $this->settings->enableSlackWebhook();

        $this->fireCheckOutEvent(
            Consumable::factory()->create(),
            User::factory()->create(),
        );

        $this->assertSlackNotificationSent(CheckoutConsumableNotification::class);
    }

    public function testConsumableCheckoutDoesNotSendSlackNotificationWhenSettingDisabled(): void
    {
        $this->settings->disableSlackWebhook();

        $this->fireCheckOutEvent(
            Consumable::factory()->create(),
            User::factory()->create(),
        );

        $this->assertNoSlackNotificationSent(CheckoutConsumableNotification::class);
    }

    #[DataProvider('licenseCheckoutTargets')]
    public function testLicenseCheckoutSendsSlackNotificationWhenSettingEnabled($checkoutTarget): void
    {
        $this->settings->enableSlackWebhook();

        $this->fireCheckOutEvent(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
        );

        $this->assertSlackNotificationSent(CheckoutLicenseSeatNotification::class);
    }

    #[DataProvider('licenseCheckoutTargets')]
    public function testLicenseCheckoutDoesNotSendSlackNotificationWhenSettingDisabled($checkoutTarget): void
    {
        $this->settings->disableSlackWebhook();

        $this->fireCheckOutEvent(
            LicenseSeat::factory()->create(),
            $checkoutTarget(),
        );

        $this->assertNoSlackNotificationSent(CheckoutLicenseSeatNotification::class);
    }

    private function fireCheckOutEvent(Model $checkoutable, Model $target)
    {
        event(new CheckoutableCheckedOut(
            $checkoutable,
            $target,
            User::factory()->superuser()->create(),
            '',
        ));
    }
}
