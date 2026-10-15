<?php

namespace Tests\Feature\Assets;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class AssetBarcodeAuthorizationTest extends TestCase
{
    public function test_barcode_route_requires_asset_view_permission()
    {
        // Reg-test for the legacy barcode endpoint's missing authz:
        // before the fix, any authenticated user could pull the barcode
        // PNG for any asset regardless of permissions or company scope,
        // enumerating protected asset tags via the rendered barcode.
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('barcode/hardware', $asset->id))
            ->assertForbidden();
    }

    public function test_barcode_route_allows_asset_viewer()
    {
        // Baseline: a user with assets.view still succeeds. Guards
        // against the authz gate over-reaching and breaking legitimate
        // access.
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->viewAssets()->create())
            ->get(route('barcode/hardware', $asset->id))
            ->assertOk();
    }
}
