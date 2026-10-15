<?php

namespace Tests\Feature\Manufacturers;

use App\Models\Manufacturer;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Manufacturer::booted()'s forceDeleted hook: hard-delete removes
 * the image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class ManufacturerForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $manufacturer = Manufacturer::factory()->create(['image' => 'maker-logo.png']);
        Storage::disk('public')->put('manufacturers/maker-logo.png', 'fake image bytes');

        $manufacturer->delete();

        Storage::disk('public')->assertExists('manufacturers/maker-logo.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $manufacturer = Manufacturer::factory()->create(['image' => 'maker-logo.png']);
        Storage::disk('public')->put('manufacturers/maker-logo.png', 'fake image bytes');

        $manufacturer->forceDelete();

        Storage::disk('public')->assertMissing('manufacturers/maker-logo.png');
    }
}
