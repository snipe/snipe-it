<?php

namespace Tests\Feature\Accessories;

use App\Models\Accessory;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Accessory::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class AccessoryForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $accessory = Accessory::factory()->create(['image' => 'mouse-pad.png']);
        Storage::disk('public')->put('accessories/mouse-pad.png', 'fake image bytes');

        $accessory->delete();

        Storage::disk('public')->assertExists('accessories/mouse-pad.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $accessory = Accessory::factory()->create(['image' => 'mouse-pad.png']);
        Storage::disk('public')->put('accessories/mouse-pad.png', 'fake image bytes');

        $accessory->forceDelete();

        Storage::disk('public')->assertMissing('accessories/mouse-pad.png');
    }
}
