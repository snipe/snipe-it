<?php

namespace Tests\Feature\Assets;

use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Asset::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class AssetForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $asset = Asset::factory()->create(['image' => 'asset-hero.png']);
        Storage::disk('public')->put('assets/asset-hero.png', 'fake image bytes');

        $asset->delete();

        Storage::disk('public')->assertExists('assets/asset-hero.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $asset = Asset::factory()->create(['image' => 'asset-hero.png']);
        Storage::disk('public')->put('assets/asset-hero.png', 'fake image bytes');

        $asset->forceDelete();

        Storage::disk('public')->assertMissing('assets/asset-hero.png');
    }
}
