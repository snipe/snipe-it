<?php

namespace Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class EditAssetTest extends TestCase
{
    public function testPageCanBeAccessed(): void
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $response = $this->actingAs($user)->get(route('hardware.edit', $asset->id));

        $response->assertStatus(200);
    }
}
