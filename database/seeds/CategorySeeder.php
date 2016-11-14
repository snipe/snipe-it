<?php
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();
        factory(Category::class, 'asset-category', 10)->create();
        factory(Category::class, 'accessory-category', 5)->create();
        factory(Category::class, 'consumable-category', 5)->create();
        factory(Category::class, 'component-category', 5)->create();
    }

}
