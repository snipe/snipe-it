<?php

namespace Tests\Feature\Checkins;

use App\Models\Asset;
use App\Models\User;
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

    public function testAssetCanBeCheckedIn()
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

    public function testLastCheckInFieldIsSetOnCheckin()
    {
        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->create(['last_checkin' => null]);

        $asset->checkOut(User::factory()->create(), $admin, now());

        $this->actingAs($admin)
            ->post(route('hardware.checkin.store', [
                'assetId' => $asset->id,
            ]))
            ->assertRedirect();

        $this->assertNotNull(
            $asset->fresh()->last_checkin,
            'last_checkin field should be set on checkin'
        );
    }
}
