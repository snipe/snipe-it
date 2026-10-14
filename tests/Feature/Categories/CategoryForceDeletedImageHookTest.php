<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Category::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class CategoryForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $category = Category::factory()->create(['image' => 'cat-icon.png']);
        Storage::disk('public')->put('categories/cat-icon.png', 'fake image bytes');

        $category->delete();

        Storage::disk('public')->assertExists('categories/cat-icon.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $category = Category::factory()->create(['image' => 'cat-icon.png']);
        Storage::disk('public')->put('categories/cat-icon.png', 'fake image bytes');

        $category->forceDelete();

        Storage::disk('public')->assertMissing('categories/cat-icon.png');
    }
}
