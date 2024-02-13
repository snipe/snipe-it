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
        $this->markTestIncomplete();
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
        $this->markTestIncomplete();
    }

    public function testLastCheckInFieldIsSetOnCheckin()
    {
        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->create(['last_checkin' => null]);

        $asset->checkOut(User::factory()->create(), $admin, now());

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
