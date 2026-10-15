<?php

namespace Tests\Feature\Account;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class PrintInventoryTest extends TestCase
{
    public function test_regular_user_without_view_assets_permission_sees_own_assets(): void
    {
        // Regression coverage for GH #19709: a user with no view-assets
        // permission would see an empty print page for their own inventory,
        // because the blade class-level @can gate blocked their own items.
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $this->actingAs($user)
            ->get(route('profile.print'))
            ->assertOk()
            ->assertSee($asset->asset_tag);
    }
}
