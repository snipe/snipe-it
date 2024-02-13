<?php

namespace Tests\Feature\Checkins;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\User;
use App\Notifications\CheckinAssetNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetCheckinTest extends TestCase
{
    use InteractsWithSettings;

    public function testCheckingInAssetRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('hardware.checkin.store', [
                'assetId' => Asset::factory()->assignedToUser()->create()->id,
            ]))
            ->assertForbidden();
    }

    public function testCannotCheckInNonExistentAsset()
    {
        $this->markTestIncomplete();
    }

    public function testCannotCheckInAssetThatIsNotCheckedOut()
    {
        $this->markTestIncomplete();
    }

    public function testAssetCheckedOutToAssetCanBeCheckedIn()
    {
        $this->markTestIncomplete();
    }

    public function testAssetCheckedOutToLocationCanBeCheckedIn()
    {
        $this->markTestIncomplete();
    }

    public function testAssetCheckedOutToUserCanBeCheckedIn()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $admin = User::factory()->checkinAssets()->create();
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $this->assertTrue($asset->assignedTo->is($user));

        $this->actingAs($admin)
            ->post(route('hardware.checkin.store', ['assetId' => $asset->id, 'backto' => 'user']))
            ->assertRedirect(route('users.show', $user));

        $this->assertNull($asset->fresh()->assignedTo);
        Event::assertDispatched(CheckoutableCheckedIn::class, 1);
    }

    public function testLastCheckInFieldIsSetOnCheckin()
    {
        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->create(['last_checkin' => null]);

        $asset->checkOut(User::factory()->create(), $admin, now());

        $this->actingAs($admin)
            ->post(route('hardware.checkin.store', [
                'assetId' => $asset->id,
            ]));

        $this->assertNotNull(
            $asset->fresh()->last_checkin,
            'last_checkin field should be set on checkin'
        );
    }

    public function testPendingCheckoutAcceptancesAreClearedUponCheckin()
    {
        $this->markTestIncomplete();
    }

    public function testCheckInEmailSentToUserIfSettingEnabled()
    {
        Notification::fake();

        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update(['checkin_email' => true]);

        event(new CheckoutableCheckedIn(
            $asset,
            $user,
            User::factory()->checkinAssets()->create(),
            ''
        ));

        Notification::assertSentTo(
            [$user],
            function (CheckinAssetNotification $notification, $channels) {
                return in_array('mail', $channels);
            },
        );
    }

    public function testCheckInEmailNotSentToUserIfSettingDisabled()
    {
        Notification::fake();

        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $asset->model->category->update(['checkin_email' => false]);

        event(new CheckoutableCheckedIn(
            $asset,
            $user,
            User::factory()->checkinAssets()->create(),
            ''
        ));

        Notification::assertNotSentTo(
            [$user],
            function (CheckinAssetNotification $notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }
}
