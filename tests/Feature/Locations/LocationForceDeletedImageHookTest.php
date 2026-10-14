<?php

namespace Tests\Feature\Locations;

use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Location::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class LocationForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $location = Location::factory()->create(['image' => 'warehouse.png']);
        Storage::disk('public')->put('locations/warehouse.png', 'fake image bytes');

        $location->delete();

        Storage::disk('public')->assertExists('locations/warehouse.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $location = Location::factory()->create(['image' => 'warehouse.png']);
        Storage::disk('public')->put('locations/warehouse.png', 'fake image bytes');

        $location->forceDelete();

        Storage::disk('public')->assertMissing('locations/warehouse.png');
    }
}
