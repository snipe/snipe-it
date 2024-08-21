<?php

namespace Tests\Feature\Notifications\Email;

use PHPUnit\Framework\Attributes\Group;
use App\Events\CheckoutableCheckedOut;
use App\Models\Asset;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

#[Group('notifications')]
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

        $asset->model->category->update(['checkin_email' => true]);

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

        $asset->model->category->update(['checkin_email' => false]); //this is a 0 so the setting IS disabled

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
        $asset = Asset::factory()->create();
        $asset->model->category->update(['checkout_email' => true]);

        $this->fireCheckOutEvent($asset, $user);

        Notification::assertSentOnDemand(
            CheckoutAssetNotification::class,
            function (CheckoutAssetNotification $notification, $channels, AnonymousNotifiable $notifiable) {
                return $notifiable->routes['mail'] === 'test@snipetest.io';
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
