<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\User;
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
        $this->markTestIncomplete();
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
