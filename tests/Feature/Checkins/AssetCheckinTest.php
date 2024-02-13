<?php

namespace Tests\Feature\Checkins;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\Statuslabel;
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

    public function testAssetCanBeCheckedIn()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $admin = User::factory()->checkinAssets()->create();
        $user = User::factory()->create();
        $status = Statuslabel::first() ?? Statuslabel::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create([
            'expected_checkin' => now()->addDay(),
            'last_checkin' => null,
            'accepted' => 'accepted',
        ]);

        $this->assertTrue($asset->assignedTo->is($user));

        $this->actingAs($admin)
            ->post(
                route('hardware.checkin.store', ['assetId' => $asset->id, 'backto' => 'user']),
                [
                    'name' => 'Changed Name',
                    'status_id' => $status->id,
                ],
            )
            ->assertRedirect(route('users.show', $user));

        Event::assertDispatched(CheckoutableCheckedIn::class, 1);
        $this->assertNull($asset->refresh()->assignedTo);
        $this->assertNull($asset->expected_checkin);
        $this->assertNull($asset->last_checkout);
        $this->assertNotNull($asset->last_checkin);
        $this->assertNull($asset->assignedTo);
        $this->assertNull($asset->assigned_type);
        $this->assertNull($asset->accepted);
        $this->assertEquals('Changed Name', $asset->name);
        $this->assertEquals($status->id, $asset->status_id);
    }

    public function testCheckinTimeAndActionLogNoteCanBeSet()
    {
        Event::fake();

        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route(
                'hardware.checkin.store',
                ['assetId' => Asset::factory()->assignedToUser()->create()->id]
            ), [
                'checkin_at' => '2023-01-02 12:45:56',
                'note' => 'hello'
            ]);

        Event::assertDispatched(function (CheckoutableCheckedIn $event) {
            return $event->action_date === '2023-01-02 12:45:56' && $event->note === 'hello';
        }, 1);
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
