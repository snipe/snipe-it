<?php
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();
        factory(Category::class, 10)->states('asset-category')->create();
        factory(Category::class, 10)->states('accessory-category')->create();
        factory(Category::class, 10)->states('component-category')->create();
        factory(Category::class, 10)->states('consumable-category')->create();
    }

}
