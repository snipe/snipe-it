<?php

namespace Tests\Feature\Checkins;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\LicenseSeat;
use App\Models\Location;
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

    public function testCannotCheckInAssetThatIsNotCheckedOut()
    {
        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route('hardware.checkin.store', ['assetId' => Asset::factory()->create()->id]))
            ->assertSessionHas('error')
            ->assertRedirect(route('hardware.index'));
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

    public function testLocationIsSetToRTDLocationByDefaultUponCheckin()
    {
        $rtdLocation = Location::factory()->create();
        $asset = Asset::factory()->assignedToUser()->create([
            'location_id' => Location::factory()->create()->id,
            'rtd_location_id' => $rtdLocation->id,
        ]);

        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route('hardware.checkin.store', ['assetId' => $asset->id]));

        $this->assertTrue($asset->refresh()->location()->is($rtdLocation));
    }

    public function testLocationCanBeSetUponCheckin()
    {
        $location = Location::factory()->create();
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route('hardware.checkin.store', ['assetId' => $asset->id]), [
                'location_id' => $location->id,
            ]);

        $this->assertTrue($asset->refresh()->location()->is($location));
    }

    public function testDefaultLocationCanBeUpdatedUponCheckin()
    {
        $location = Location::factory()->create();
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route('hardware.checkin.store', ['assetId' => $asset->id]), [
                'location_id' => $location->id,
                'update_default_location' => 0
            ]);

        $this->assertTrue($asset->refresh()->defaultLoc()->is($location));
    }

    public function testLastCheckInFieldIsSetOnCheckin()
    {
        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->assignedToUser()->create(['last_checkin' => null]);

        $this->actingAs($admin)
            ->post(route('hardware.checkin.store', [
                'assetId' => $asset->id,
            ]));

        $this->assertNotNull(
            $asset->refresh()->last_checkin,
            'last_checkin field should be set on checkin'
        );
    }

    public function testAssetsLicenseSeatsAreClearedUponCheckin()
    {
        $asset = Asset::factory()->assignedToUser()->create();
        LicenseSeat::factory()->assignedToUser()->for($asset)->create();

        $this->assertNotNull($asset->licenseseats->first()->assigned_to);

        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route('hardware.checkin.store', ['assetId' => $asset->id]));

        $this->assertNull($asset->refresh()->licenseseats->first()->assigned_to);
    }

    public function testLegacyLocationValuesSetToZeroAreUpdated()
    {
        $asset = Asset::factory()->canBeInvalidUponCreation()->assignedToUser()->create([
            'rtd_location_id' => 0,
            'location_id' => 0,
        ]);

        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route('hardware.checkin.store', ['assetId' => $asset->id]));

        $this->assertNull($asset->refresh()->rtd_location_id);
        $this->assertNull($asset->location_id);
    }

    public function testPendingCheckoutAcceptancesAreClearedUponCheckin()
    {
        $asset = Asset::factory()->assignedToUser()->create();

        $acceptance = CheckoutAcceptance::factory()->for($asset, 'checkoutable')->pending()->create();

        $this->actingAs(User::factory()->checkinAssets()->create())
            ->post(route('hardware.checkin.store', ['assetId' => $asset->id]));

        $this->assertFalse($acceptance->exists(), 'Acceptance was not deleted');
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
