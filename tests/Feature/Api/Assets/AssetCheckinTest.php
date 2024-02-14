<?php

namespace Tests\Feature\Api\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
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
            ->postJson(route('api.asset.checkin', $asset->id), [
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

    public function testLastCheckInFieldIsSetOnCheckin()
    {
        $admin = User::factory()->checkinAssets()->create();
        $asset = Asset::factory()->assignedToUser()->create(['last_checkin' => null]);

        $this->actingAsForApi($admin)
            ->postJson(route('api.asset.checkin', $asset))
            ->assertOk();

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
        $this->markTestIncomplete();
    }

    public function testCheckInEmailNotSentToUserIfSettingDisabled()
    {
        $this->markTestIncomplete();
    }
}
