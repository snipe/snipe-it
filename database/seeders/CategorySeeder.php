<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        Category::factory()->count(1)->assetLaptopCategory()->create();
        Category::factory()->count(1)->assetDesktopCategory()->create();
        Category::factory()->count(1)->assetTabletCategory()->create();
        Category::factory()->count(1)->assetMobileCategory()->create();
        Category::factory()->count(1)->assetDisplayCategory()->create();
        Category::factory()->count(1)->assetVoipCategory()->create();
        Category::factory()->count(1)->assetConferencePhoneCategory()->create();
        Category::factory()->count(1)->accessoryKeyboardCategory()->create();
        Category::factory()->count(1)->accessoryMouseCategory()->create();
        Category::factory()->count(1)->consumablePaperCategory()->create();
        Category::factory()->count(1)->consumableInkCategory()->create();
        Category::factory()->count(1)->componentHddCategory()->create();
        Category::factory()->count(1)->componentRamCategory()->create();
        Category::factory()->count(1)->licenseGraphicsCategory()->create();
        Category::factory()->count(1)->licenceOfficeCategory()->create();

    }

}
