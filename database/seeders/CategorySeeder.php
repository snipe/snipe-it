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

        Category::factory()->count(1)->assetLaptopCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->assetDesktopCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->assetTabletCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->assetMobileCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->assetDisplayCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->assetVoipCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->assetConferenceCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->accessoryKeyboardCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->accessoryMouseCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->consumablePaperCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->consumableInkCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->componentHddCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->componentRamCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->licenseGraphicsCategory()->create(['user_id' => $admin->id]);
        Category::factory()->count(1)->licenseOfficeCategory()->create(['user_id' => $admin->id]);
    }
}
