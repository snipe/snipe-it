<?php

namespace Tests\Feature\Companies;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers Company::booted()'s forceDeleted hook: hard-delete removes the
 * image file on the public disk, soft-delete leaves it so a subsequent
 * restore comes back with the image intact.
 */
class CompanyForceDeletedImageHookTest extends TestCase
{
    public function test_soft_delete_preserves_image_file(): void
    {
        Storage::fake('public');
        $company = Company::factory()->create(['image' => 'acme-logo.png']);
        Storage::disk('public')->put('companies/acme-logo.png', 'fake image bytes');

        $company->delete();

        Storage::disk('public')->assertExists('companies/acme-logo.png');
    }

    public function test_force_delete_wipes_image_file(): void
    {
        Storage::fake('public');
        $company = Company::factory()->create(['image' => 'acme-logo.png']);
        Storage::disk('public')->put('companies/acme-logo.png', 'fake image bytes');

        $company->forceDelete();

        Storage::disk('public')->assertMissing('companies/acme-logo.png');
    }
}
