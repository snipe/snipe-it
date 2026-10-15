<?php

namespace Tests\Feature\Departments;

use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Department::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class DepartmentForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $department = Department::factory()->create(['image' => 'dept-badge.png']);
        Storage::disk('public')->put('departments/dept-badge.png', 'fake image bytes');

        $department->delete();

        Storage::disk('public')->assertExists('departments/dept-badge.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $department = Department::factory()->create(['image' => 'dept-badge.png']);
        Storage::disk('public')->put('departments/dept-badge.png', 'fake image bytes');

        $department->forceDelete();

        Storage::disk('public')->assertMissing('departments/dept-badge.png');
    }
}
