<?php

namespace Tests\Feature\Notifications\Email;

use PHPUnit\Framework\Attributes\Group;
use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\User;
use App\Notifications\CheckinAssetNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

#[Group('notifications')]
class EmailNotificationsUponCheckinTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    public function testCheckInEmailSentToUserIfSettingEnabled()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update(['checkin_email' => true]);

        $this->fireCheckInEvent($asset, $user);

        Notification::assertSentTo(
            $user,
            function (CheckinAssetNotification $notification, $channels) {
                return in_array('mail', $channels);
            },
        );
    }

    public function testCheckInEmailNotSentToUserIfSettingDisabled()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update(['checkin_email' => false]);

        $this->fireCheckInEvent($asset, $user);

        Notification::assertNotSentTo(
            $user,
            function (CheckinAssetNotification $notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }

    private function fireCheckInEvent($asset, $user): void
    {
        event(new CheckoutableCheckedIn(
            $asset,
            $user,
            User::factory()->checkinAssets()->create(),
            ''
        ));
    }
}
