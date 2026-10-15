<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        // Wipe every item file in the public uploads dir.
        $disk = Storage::disk('public');
        foreach ($disk->files('categories') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                $disk->delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        Category::factory()->count(1)->assetLaptopCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->assetDesktopCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->assetTabletCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->assetMobileCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->assetDisplayCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->assetVoipCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->assetConferenceCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->accessoryKeyboardCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->accessoryMouseCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->consumablePaperCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->consumableInkCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->componentHddCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->componentRamCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->licenseGraphicsCategory()->create(['created_by' => $admin->id]);
        Category::factory()->count(1)->licenseOfficeCategory()->create(['created_by' => $admin->id]);
    }
}
