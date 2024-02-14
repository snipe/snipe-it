<?php

namespace Tests\Feature\Api\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetCheckinTest extends TestCase
{
    use InteractsWithSettings;

    public function testCheckingInAssetRequiresCorrectPermission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.asset.checkin', Asset::factory()->assignedToUser()->create()))
            ->assertForbidden();
    }

    public function testCannotCheckInNonExistentAsset()
    {
        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', ['id' => 'does-not-exist']))
            ->assertStatusMessageIs('error');
    }

    public function testCannotCheckInAssetThatIsNotCheckedOut()
    {
        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', Asset::factory()->create()->id))
            ->assertStatusMessageIs('error');
    }

    public function testAssetCanBeCheckedIn()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $user = User::factory()->create();
        $status = Statuslabel::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create([
            'expected_checkin' => now()->addDay(),
            'last_checkin' => null,
            'accepted' => 'accepted',
        ]);

        $this->assertTrue($asset->assignedTo->is($user));

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', $asset), [
                'name' => 'Changed Name',
                'status_id' => $status->id,
            ])
            ->assertOk();

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

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', $asset->id));

        $this->assertTrue($asset->refresh()->location()->is($rtdLocation));
    }

    public function testLocationCanBeSetUponCheckin()
    {
        $location = Location::factory()->create();
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', $asset->id), [
                'location_id' => $location->id,
            ]);

        $this->assertTrue($asset->refresh()->location()->is($location));
    }

    public function testDefaultLocationCanBeUpdatedUponCheckin()
    {
        $this->markTestIncomplete('Not currently in controller');

        $location = Location::factory()->create();
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', $asset), [
                'location_id' => $location->id,
                'update_default_location' => 0
            ]);

        $this->assertTrue($asset->refresh()->defaultLoc()->is($location));
    }

    public function testAssetsLicenseSeatsAreClearedUponCheckin()
    {
        $this->markTestIncomplete('Not currently in controller');

        $asset = Asset::factory()->assignedToUser()->create();
        LicenseSeat::factory()->assignedToUser()->for($asset)->create();

        $this->assertNotNull($asset->licenseseats->first()->assigned_to);

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', $asset));

        $this->assertNull($asset->refresh()->licenseseats->first()->assigned_to);
    }

    public function testLegacyLocationValuesSetToZeroAreUpdated()
    {
        $this->markTestIncomplete('Not currently in controller');
    }

    public function testPendingCheckoutAcceptancesAreClearedUponCheckin()
    {
        $this->markTestIncomplete('Not currently in controller');
    }

    public function testCheckinTimeAndActionLogNoteCanBeSet()
    {
        $this->markTestIncomplete(
            'checkin_at currently takes a date and applies a time which is not inline with what the web controller does.'
        );

        Event::fake();

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkin', Asset::factory()->assignedToUser()->create()), [
                'checkin_at' => '2023-01-02 12:34:56',
                'note' => 'hi there',
            ]);

        Event::assertDispatched(function (CheckoutableCheckedIn $event) {
            return $event->action_date === '2023-01-02 12:34:56' && $event->note === 'hi there';
        }, 1);
    }
}
