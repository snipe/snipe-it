<?php

namespace Tests\Feature\Notifications;

use App\Models\Asset;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AssetCheckoutWebhookNotificationTest extends TestCase
{

    public function checkoutTargets()
    {
        return [
            'Asset checked out to user' => [fn() => User::factory()->create()],
            'Asset checked out to asset' => [fn() => $this->createAsset()],
            'Asset checked out to location' => [fn() => Location::factory()->create()],
        ];
    }

    /** @dataProvider checkoutTargets */
    public function testWebhookNotificationsAreSentOnAssetCheckoutWhenWebhookSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        Setting::factory()->withWebhookEnabled()->create();

        $this->createAsset()->checkOut(
            $checkoutTarget(),
            User::factory()->superuser()->create()->id
        );

        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    /** @dataProvider checkoutTargets */
    public function testWebhookNotificationsAreNotSentOnAssetCheckoutWhenWebhookSettingNotEnabled($checkoutTarget)
    {
        Notification::fake();

        $this->createAsset()->checkOut(
            $checkoutTarget(),
            User::factory()->superuser()->create()->id
        );

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutAssetNotification::class);
    }

    private function createAsset()
    {
        return Asset::factory()->laptopMbp()->create();
    }
}
