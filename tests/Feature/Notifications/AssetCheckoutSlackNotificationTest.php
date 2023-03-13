<?php

namespace Tests\Feature\Notifications;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AssetCheckoutSlackNotificationTest extends TestCase
{
    public function testNotificationSentToSlackWhenAssetCheckedOutToUserAndSlackNotificationEnabled()
    {
        Notification::fake();

        $this->setSlackWebhook();

        $asset = $this->createAsset();
        $user = User::factory()->create();

        $asset->checkOut(
            $user,
            User::factory()->superuser()->create()->id
        );

        $this->assetSlackNotificationSentTo($user);
    }

    public function testNotificationSentToSlackWhenAssetCheckedOutToAssetAndSlackNotificationEnabled()
    {
        $this->markTestIncomplete();

        Notification::fake();

        $this->setSlackWebhook();

        $assetBeingCheckedOut = $this->createAsset();
        $targetAsset = $this->createAsset();

        $assetBeingCheckedOut->checkOut(
            $targetAsset,
            User::factory()->superuser()->create()->id
        );

        $this->assetSlackNotificationSentTo($targetAsset);
    }

    public function testNotificationSentToSlackWhenAssetCheckedOutToLocationAndSlackNotificationEnabled()
    {
        $this->markTestIncomplete();

        Notification::fake();

        $this->setSlackWebhook();

        $asset = $this->createAsset();
        $location = Location::factory()->create();

        $asset->checkOut(
            $location,
            User::factory()->superuser()->create()->id
        );

        $this->assetSlackNotificationSentTo($location);
    }

    private function setSlackWebhook()
    {
        Setting::factory()->create([
            'slack_endpoint' => 'https://hooks.slack.com/services/NZ59O2F54K/Q4465WNLM8/672N8MU5JV15RP436WDHRN58',
        ]);
    }

    private function createAsset()
    {
        return Asset::factory()->create([
            'model_id' => AssetModel::factory()->create([
                'category_id' => Category::factory()->assetLaptopCategory()->id,
            ])->id,
        ]);
    }

    private function assetSlackNotificationSentTo($target)
    {
        Notification::assertSentTo(
            $target,
            function (CheckoutAssetNotification $notification, $channels) {
                return in_array('slack', $channels);
            }
        );
    }
}
