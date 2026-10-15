<?php

namespace Tests\Feature\Consumables;

use App\Models\Consumable;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Consumable::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class ConsumableForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $consumable = Consumable::factory()->create(['image' => 'ink-cart.png']);
        Storage::disk('public')->put('consumables/ink-cart.png', 'fake image bytes');

        $consumable->delete();

        Storage::disk('public')->assertExists('consumables/ink-cart.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $consumable = Consumable::factory()->create(['image' => 'ink-cart.png']);
        Storage::disk('public')->put('consumables/ink-cart.png', 'fake image bytes');

        $consumable->forceDelete();

        Storage::disk('public')->assertMissing('consumables/ink-cart.png');
    }
}
