<?php
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        factory(Category::class, 1)->states('asset-laptop-category')->create();
        factory(Category::class, 1)->states('asset-desktop-category')->create();
        factory(Category::class, 1)->states('asset-tablet-category')->create();
        factory(Category::class, 1)->states('asset-mobile-category')->create();
        factory(Category::class, 1)->states('asset-display-category')->create();
        factory(Category::class, 1)->states('asset-voip-category')->create();
        factory(Category::class, 1)->states('asset-conference-category')->create();
        factory(Category::class, 1)->states('accessory-keyboard-category')->create();
        factory(Category::class, 1)->states('accessory-mouse-category')->create();
        factory(Category::class, 1)->states('consumable-paper-category')->create();
        factory(Category::class, 1)->states('consumable-ink-category')->create();
        factory(Category::class, 1)->states('component-hdd-category')->create();
        factory(Category::class, 1)->states('component-ram-category')->create();
    }

}
