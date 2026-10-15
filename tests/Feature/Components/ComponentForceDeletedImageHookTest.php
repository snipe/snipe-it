<?php

namespace Tests\Feature\Components;

use App\Models\Component;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Component::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class ComponentForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $component = Component::factory()->create(['image' => 'ram-stick.png']);
        Storage::disk('public')->put('components/ram-stick.png', 'fake image bytes');

        $component->delete();

        Storage::disk('public')->assertExists('components/ram-stick.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $component = Component::factory()->create(['image' => 'ram-stick.png']);
        Storage::disk('public')->put('components/ram-stick.png', 'fake image bytes');

        $component->forceDelete();

        Storage::disk('public')->assertMissing('components/ram-stick.png');
    }
}
