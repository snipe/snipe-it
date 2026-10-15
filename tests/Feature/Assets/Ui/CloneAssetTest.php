<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class CloneAssetTest extends TestCase
{
    public function test_permission_required_to_clone_asset()
    {
        $asset = Asset::factory()->create();
        $this->actingAs(User::factory()->create())
            ->get(route('clone/hardware', $asset))
            ->assertForbidden();
    }

    public function test_page_can_be_accessed(): void
    {
        $asset = Asset::factory()->create();
        $response = $this->actingAs(User::factory()->cloneAssets()->create())
            ->get(route('clone/hardware', $asset));
        $response->assertStatus(200);
    }

    public function test_asset_can_be_cloned()
    {
        $asset_to_clone = Asset::factory()->create(['name' => 'Asset to clone']);
        $this->actingAs(User::factory()->cloneAssets()->create())
            ->get(route('clone/hardware', $asset_to_clone))
            ->assertOk()
            ->assertSee([
                'Asset to clone',
            ], false);
    }

    public function test_create_permission_alone_is_not_enough_to_clone_asset()
    {
        // Cloning renders the source asset's data into the create form, so
        // a user with only assets.create (no assets.view) must be blocked.
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->createAssets()->create())
            ->get(route('clone/hardware', $asset))
            ->assertForbidden();
    }
}
