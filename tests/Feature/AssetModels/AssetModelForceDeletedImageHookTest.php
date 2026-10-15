<?php

namespace Tests\Feature\AssetModels;

use App\Models\AssetModel;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers AssetModel::booted()'s forceDeleted hook: hard-delete removes
 * the image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class AssetModelForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $model = AssetModel::factory()->create(['image' => 'macbook-pro.png']);
        Storage::disk('public')->put('models/macbook-pro.png', 'fake image bytes');

        $model->delete();

        Storage::disk('public')->assertExists('models/macbook-pro.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $model = AssetModel::factory()->create(['image' => 'macbook-pro.png']);
        Storage::disk('public')->put('models/macbook-pro.png', 'fake image bytes');

        $model->forceDelete();

        Storage::disk('public')->assertMissing('models/macbook-pro.png');
    }
}
