<?php

namespace Tests\Feature\Suppliers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Supplier::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class SupplierForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $supplier = Supplier::factory()->create(['image' => 'vendor-logo.png']);
        Storage::disk('public')->put('suppliers/vendor-logo.png', 'fake image bytes');

        $supplier->delete();

        Storage::disk('public')->assertExists('suppliers/vendor-logo.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $supplier = Supplier::factory()->create(['image' => 'vendor-logo.png']);
        Storage::disk('public')->put('suppliers/vendor-logo.png', 'fake image bytes');

        $supplier->forceDelete();

        Storage::disk('public')->assertMissing('suppliers/vendor-logo.png');
    }
}
