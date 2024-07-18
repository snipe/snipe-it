<?php

namespace Tests\Feature\Notifications\Email;

use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\User;
use App\Notifications\CheckOutAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * @group notifications
 */
class EmailNotificationsUponCheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public function testCheckOutEmailSentToUserIfSettingEnabled()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update(['checkout_email' => true]);

        $this->fireCheckOutEvent($asset, $user);

        Notification::assertSentTo(
            $user,
            function (CheckOutAssetNotification $notification, $channels) {
                return in_array('mail', $channels);
            },
        );
    }

    public function testCheckOutEmailNotSentToUserIfSettingDisabled()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update(['checkout_email' => false]);

        $this->fireCheckOutEvent($asset, $user);

        Notification::assertNotSentTo(
            $user,
            function (CheckOutAssetNotification $notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }

    public function testCheckOutEmailSentToAdminIfUserEmailNull() {
        $this->settings->enableCCEmail("test@snipetest.io");

        $user = User::factory()->create(["email"=>null]);
        $admin = User::factory()->admin()->create(["email"=>"test@snipetest.io"]);
        $asset = Asset::factory()->assignedToUser($user)->create();
        $asset->model->category->update(['checkout_email' => true]);
        $this->fireCheckOutEvent($asset, $user);

        Notification::assertNotSentTo(
            $user,
            function (CheckOutAssetNotification $notification, $channels) {
                return in_array('mail', $channels);
            }
        );

        Notification::assertSentOnDemand(
            CheckOutAssetNotification::class,
            function (CheckOutAssetNotification $notification, $channels, $notifiable) {
            }
        );
    }

    private function fireCheckOutEvent($asset, $user): void
    {
        event(new CheckoutableCheckedOut(
            $asset,
            $user,
            User::factory()->checkoutAssets()->create(),
            ''
        ));
    }
}
