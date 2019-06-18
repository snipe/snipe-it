<?php
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        factory(Category::class, 1)->states('asset-laptop-category')->create(); // 1
        factory(Category::class, 1)->states('asset-desktop-category')->create(); // 2
        factory(Category::class, 1)->states('asset-tablet-category')->create(); // 3
        factory(Category::class, 1)->states('asset-mobile-category')->create(); // 4
        factory(Category::class, 1)->states('asset-display-category')->create(); // 5
        factory(Category::class, 1)->states('asset-voip-category')->create(); // 6
        factory(Category::class, 1)->states('asset-conference-category')->create(); // 7
        factory(Category::class, 1)->states('accessory-keyboard-category')->create(); // 8
        factory(Category::class, 1)->states('accessory-mouse-category')->create(); // 9
        factory(Category::class, 1)->states('consumable-paper-category')->create(); // 10
        factory(Category::class, 1)->states('consumable-ink-category')->create(); // 11
        factory(Category::class, 1)->states('component-hdd-category')->create(); // 12
        factory(Category::class, 1)->states('component-ram-category')->create(); // 13
        factory(Category::class, 1)->states('license-graphics-category')->create(); // 14
        factory(Category::class, 1)->states('license-office-category')->create(); // 15
    }

}
