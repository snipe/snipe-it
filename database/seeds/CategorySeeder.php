<?php
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();
        factory(Category::class, 'category', 10)->create(['category_type' => 'asset']);
        factory(Category::class, 'category', 10)->create(['category_type' => 'accessory']);
        factory(Category::class, 'category', 10)->create(['category_type' => 'consumable']);
        factory(Category::class, 'category', 10)->create(['category_type' => 'component']);
    }

}
