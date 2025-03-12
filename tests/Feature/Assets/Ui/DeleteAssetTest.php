<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class DeleteAssetTest extends TestCase
{
    public function test_asset_can_be_deleted_with_permissions()
    {
        $user = User::factory()->deleteAssets()->create();

        $asset = Asset::factory()->create();
        $this->actingAs($user)
            ->delete(route('hardware.destroy', $asset))
            ->assertRedirect(route('hardware.index'));

        $this->assertSoftDeleted($asset);
    }

    public function test_asset_cannot_be_deleted_without_permissions()
    {
        $user = User::factory()->create();

        $asset = Asset::factory()->create();
        $this->actingAs($user)
            ->delete(route('hardware.destroy', $asset))
            ->assertForbidden();

        $this->assertModelExists($asset);
    }

}