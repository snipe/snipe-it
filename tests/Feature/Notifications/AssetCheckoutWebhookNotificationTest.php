<?php

namespace Tests\Feature\Notifications;

use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
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

    public function testAssetCheckoutFiresCheckoutEvent()
    {
        Event::fake([CheckoutableCheckedOut::class]);

        $this->createAsset()->checkOut(User::factory()->create(), User::factory()->create());

        Event::assertDispatched(CheckoutableCheckedOut::class);
    }

    /** @dataProvider checkoutTargets */
    public function testWebhookNotificationsAreSentOnAssetCheckoutWhenWebhookSettingEnabled($checkoutTarget)
    {
        Notification::fake();

        Setting::factory()->withWebhookEnabled()->create();

        event(new CheckoutableCheckedOut(
            $this->createAsset(),
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

    /** @dataProvider checkoutTargets */
    public function testWebhookNotificationsAreNotSentOnAssetCheckoutWhenWebhookSettingNotEnabled($checkoutTarget)
    {
        Notification::fake();

        event(new CheckoutableCheckedOut(
            $this->createAsset(),
            $checkoutTarget(),
            User::factory()->superuser()->create(),
            ''
        ));

        Notification::assertNotSentTo(new AnonymousNotifiable, CheckoutAssetNotification::class);
    }

    private function createAsset()
    {
        return Asset::factory()->laptopMbp()->create();
    }
}
