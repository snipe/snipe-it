<?php

namespace Tests\Feature\Checkins\Api;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class AssetCheckinByTagTest extends TestCase
{
    public function test_checking_in_asset_by_tag_requires_correct_permission()
    {
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.asset.checkinbytag'), ['asset_tag' => $asset->asset_tag])
            ->assertForbidden();
    }

    public function test_asset_can_be_checked_in_by_tag()
    {
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), ['asset_tag' => $asset->asset_tag])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertNull($asset->refresh()->assignedTo);
    }

    public function test_checkin_by_tag_returns_error_for_unknown_tag()
    {
        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), ['asset_tag' => 'DOES-NOT-EXIST'])
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function test_asset_name_is_cleared_on_checkin_by_tag_when_clear_name_is_set()
    {
        $asset = Asset::factory()->assignedToUser()->create(['name' => 'My Asset Name']);

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), [
                'asset_tag' => $asset->asset_tag,
                'clear_name' => '1',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertNull($asset->refresh()->name);
    }

    public function test_asset_name_is_not_cleared_on_checkin_by_tag_when_clear_name_is_not_set()
    {
        $asset = Asset::factory()->assignedToUser()->create(['name' => 'My Asset Name']);

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), ['asset_tag' => $asset->asset_tag])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertEquals('My Asset Name', $asset->refresh()->name);
    }

    // -------------------------------------------------------------------------
    // Body-based checkin_key + checkin_by_field lookup (mirrors the audit path)
    // -------------------------------------------------------------------------

    public function test_asset_can_be_checked_in_by_asset_tag_via_checkin_key()
    {
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), [
                'checkin_key' => $asset->asset_tag,
                'checkin_by_field' => 'asset_tag',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertNull($asset->refresh()->assignedTo);
    }

    public function test_asset_can_be_checked_in_by_serial_when_unique_serial_is_enabled()
    {
        $this->settings->set(['unique_serial' => '1']);

        $asset = Asset::factory()->assignedToUser()->create(['serial' => 'SN-CHECKIN-BY-SERIAL-1']);

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), [
                'checkin_key' => 'SN-CHECKIN-BY-SERIAL-1',
                'checkin_by_field' => 'serial',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertNull($asset->refresh()->assignedTo);
    }

    public function test_checkin_by_serial_is_refused_when_unique_serial_is_disabled()
    {
        // Guard rail: when serial uniqueness is not enforced, serial-based checkin
        // must not resolve (matches the audit-side behavior).
        $this->settings->set(['unique_serial' => '0']);

        $asset = Asset::factory()->assignedToUser()->create(['serial' => 'SN-DISABLED-1']);

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), [
                'checkin_key' => 'SN-DISABLED-1',
                'checkin_by_field' => 'serial',
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');

        // Asset stays assigned because no lookup should have resolved it.
        $this->assertNotNull($asset->refresh()->assignedTo);
    }

    public function test_legacy_asset_tag_body_field_still_works_for_backward_compat()
    {
        // Callers that predate the checkin_key convention (older integrations,
        // the pre-serial quickscan-checkin blade) send `asset_tag` in the body.
        // That path must keep working after the resolver refactor.
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAsForApi(User::factory()->checkinAssets()->create())
            ->postJson(route('api.asset.checkinbytag'), [
                'asset_tag' => $asset->asset_tag,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertNull($asset->refresh()->assignedTo);
    }
}
