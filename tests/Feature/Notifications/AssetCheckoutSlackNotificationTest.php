<?php

namespace Tests\Feature\Notifications;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AssetCheckoutSlackNotificationTest extends TestCase
{
    private Category $assetLaptopCategory;
    private string $slackWebhookUrl = 'https://hooks.slack.com/services/NZ59O2F54K/Q4465WNLM8/672N8MU5JV15RP436WDHRN58';

    protected function setUp(): void
    {
        parent::setUp();

        $this->assetLaptopCategory = Category::factory()->assetLaptopCategory();
    }

    public function testNotificationSentToSlackWhenAssetCheckedOutToUserAndSlackNotificationEnabled()
    {
        Notification::fake();

        Setting::factory()->create(['slack_endpoint' => $this->slackWebhookUrl]);

        $asset = $this->createAsset();
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

        Setting::factory()->create(['slack_endpoint' => $this->slackWebhookUrl]);

        $assetBeingCheckedOut = $this->createAsset();
        $assetBeingCheckedOut->checkOut(
            $this->createAsset(),
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

        $assetBeingCheckedOut = $this->createAsset();
        $assetBeingCheckedOut->checkOut(
            $this->createAsset(),
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

        Setting::factory()->create(['slack_endpoint' => $this->slackWebhookUrl]);

        $asset = $this->createAsset();
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

        $asset = $this->createAsset();
        $asset->checkOut(
            Location::factory()->create(),
            User::factory()->superuser()->create()->id
        );

        Notification::assertNotSentTo(
            new AnonymousNotifiable,
            CheckoutAssetNotification::class,
        );
    }

    private function createAsset()
    {
        return Asset::factory()->create([
            'model_id' => AssetModel::factory()->create([
                'category_id' => $this->assetLaptopCategory->id,
            ])->id,
        ]);
    }
}
