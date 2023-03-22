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
    public function testNotificationSentToWebhookWhenAssetCheckedOutToUserAndWebhookNotificationEnabled()
    {
        Notification::fake();

        $this->enableWebhookSettings();

        $user = $this->createUser();

        $this->createAsset()->checkOut(
            $user,
            $this->createSuperUser()->id
        );

        Notification::assertSentTo(
            $user,
            function (CheckoutAssetNotification $notification, $channels) {
                // @todo: is this actually accurate?
                return in_array('slack', $channels);
            }
        );
    }

    public function testNotificationSentToWebhookWhenAssetCheckedOutToAssetAndWebhookNotificationEnabled()
    {
        Notification::fake();

        $this->enableWebhookSettings();

        $this->createAsset()->checkOut(
            $this->createAsset(),
            $this->createSuperUser()->id
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

    public function testDoesNotSendNotificationViaWebhookIfWebHookEndpointIsNotSetWhenCheckingOutAssetToAsset()
    {
        Notification::fake();

        $this->createAsset()->checkOut(
            $this->createAsset(),
            $this->createSuperUser()->id
        );

        Notification::assertNotSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
        );
    }

    public function testNotificationSentToWebhookWhenAssetCheckedOutToLocationAndWebhookNotificationEnabled()
    {
        Notification::fake();

        $this->enableWebhookSettings();

        $this->createAsset()->checkOut(
            Location::factory()->create(),
            $this->createSuperUser()->id
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

    public function testDoesNotSendNotificationViaWebhookIfWebHookEndpointIsNotSetWhenCheckingOutAssetToLocation()
    {
        Notification::fake();

        $this->createAsset()->checkOut(
            Location::factory()->create(),
            $this->createSuperUser()->id
        );

        Notification::assertNotSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
        );
    }

    private function enableWebhookSettings()
    {
        Setting::factory()->withWebhookEnabled()->create();
    }

    private function createAsset()
    {
        return Asset::factory()->laptopMbp()->create();
    }

    private function createUser()
    {
        return User::factory()->create();
    }

    private function createSuperUser()
    {
        return User::factory()->superuser()->create();
    }
}
