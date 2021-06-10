<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        Category::factory()->count(1)->assetLaptopCategory()->create(); // 1
        Category::factory()->count(1)->assetDesktopCategory()->create(); // 2
        Category::factory()->count(1)->assetTabletCategory()->create(); // 3
        Category::factory()->count(1)->assetMobileCategory()->create(); // 4
        Category::factory()->count(1)->assetDisplayCategory()->create(); // 5
        Category::factory()->count(1)->assetVoipCategory()->create(); // 6
        Category::factory()->count(1)->assetConferenceCategory()->create(); // 7
        Category::factory()->count(1)->accessoryKeyboardCategory()->create(); // 8
        Category::factory()->count(1)->accessoryMouseCategory()->create(); // 9
        Category::factory()->count(1)->consumablePaperCategory()->create(); // 10
        Category::factory()->count(1)->consumableInkCategory()->create(); // 11
        Category::factory()->count(1)->componentHddCategory()->create(); // 12
        Category::factory()->count(1)->componentRamCategory()->create(); // 13
        Category::factory()->count(1)->licenseGraphicsCategory()->create(); // 14
        Category::factory()->count(1)->licenseOfficeCategory()->create(); // 15
    }
}
