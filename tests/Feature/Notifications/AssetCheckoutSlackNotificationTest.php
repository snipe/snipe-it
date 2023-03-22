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
    private string $slackWebhookUrl = 'https://hooks.slack.com/services/NZ59O2F54K/Q4465WNLM8/672N8MU5JV15RP436WDHRN58';

    public function testNotificationSentToSlackWhenAssetCheckedOutToUserAndSlackNotificationEnabled()
    {
        Notification::fake();

        Setting::factory()->create(['webhook_endpoint' => $this->slackWebhookUrl]);

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

        Setting::factory()->create(['webhook_endpoint' => $this->slackWebhookUrl]);

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
                return $notifiable->routes['slack'] === $this->slackWebhookUrl;
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

        Setting::factory()->create(['webhook_endpoint' => $this->slackWebhookUrl]);

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
                return $notifiable->routes['slack'] === $this->slackWebhookUrl;
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
