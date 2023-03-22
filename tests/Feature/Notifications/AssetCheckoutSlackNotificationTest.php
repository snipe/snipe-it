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

class AssetCheckoutSlackNotificationTest extends TestCase
{
    public function testNotificationSentToSlackWhenAssetCheckedOutToUserAndSlackNotificationEnabled()
    {
        Notification::fake();

        Setting::factory()->withWebhookEnabled()->create();

        $asset = Asset::factory()->laptopMbp()->create();
        $user = User::factory()->create();

        $asset->checkOut(
            $user,
            User::factory()->superuser()->create()->id
        );

        Notification::assertSentTo(
            $user,
            function (CheckoutAssetNotification $notification, $channels) {
                // @todo: is this actually accurate?
                return in_array('slack', $channels);
            }
        );
    }

    public function testNotificationSentToSlackWhenAssetCheckedOutToAssetAndSlackNotificationEnabled()
    {
        Notification::fake();

        Setting::factory()->withWebhookEnabled()->create();

        $assetBeingCheckedOut = Asset::factory()->laptopMbp()->create();
        $assetBeingCheckedOut->checkOut(
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create()->id
        );

        // Since the target is not a user with an email address we have
        // to check if an AnonymousNotifiable was sent.
        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testDoesNotSendNotificationViaSlackIfWebHookEndpointIsNotSetWhenCheckingOutAssetToAsset()
    {
        Notification::fake();

        $assetBeingCheckedOut = Asset::factory()->laptopMbp()->create();
        $assetBeingCheckedOut->checkOut(
            Asset::factory()->laptopMbp()->create(),
            User::factory()->superuser()->create()->id
        );

        Notification::assertNotSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
        );
    }

    public function testNotificationSentToSlackWhenAssetCheckedOutToLocationAndSlackNotificationEnabled()
    {
        Notification::fake();

        Setting::factory()->withWebhookEnabled()->create();

        $asset = Asset::factory()->laptopMbp()->create();
        $asset->checkOut(
            Location::factory()->create(),
            User::factory()->superuser()->create()->id
        );

        // Since the target is not a user with an email address we have
        // to check if an AnonymousNotifiable was sent.
        Notification::assertSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Setting::getSettings()->webhook_endpoint;
            }
        );
    }

    public function testDoesNotSendNotificationViaSlackIfWebHookEndpointIsNotSetWhenCheckingOutAssetToLocation()
    {
        Notification::fake();

        $asset = Asset::factory()->laptopMbp()->create();
        $asset->checkOut(
            Location::factory()->create(),
            User::factory()->superuser()->create()->id
        );

        Notification::assertNotSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
        );
    }
}
