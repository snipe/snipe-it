<?php

namespace Tests\Feature\Assets;

use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class AssetsBulkEditTest extends TestCase
{
    public function testBulkEditAsset()
    {
        $assets = Asset::factory()->count(10)->create(['purchase_date' => '2023-01-01']);

        $id_array = $assets->pluck('id')->toArray();

        $response = $this->actingAs(User::factory()->editAssets()->create())->post(route('hardware/bulksave'), [
            'ids'           => array_values($id_array),
            'purchase_date' => '2024-01-01'
        ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        Asset::findMany($id_array)->each(function (Asset $asset) {
            $this->assertEquals('2024-01-01', $asset->purchase_date->format('Y-m-d'));
        });

        $this->assertDatabaseHas('assets', [
            'purchase_date' => '2024-01-01'
        ]);
    }
}
