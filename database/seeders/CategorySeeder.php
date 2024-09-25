<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

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
