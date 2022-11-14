<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Category Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating categories and the various states..
|
*/

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase(),
            'checkin_email' => $this->faker->boolean(),
            'eula_text' => $this->faker->paragraph(),
            'require_acceptance' => false,
            'use_default_eula' => $this->faker->boolean(),
            'user_id' => 1,
        ];
    }

    // usage: Category::factory()->assetLaptopCategory();
    public function assetLaptopCategory()
    {
        return Category::factory()->create([
            'name' => 'Laptops',
            'category_type' => 'asset',
            'require_acceptance' => true,
        ]);
    }

    // usage: Category::factory()->assetDesktopCategory();
    public function assetDesktopCategory()
    {
        return Category::factory()->create([
            'name' => 'Desktops',
            'category_type' => 'asset',
            'require_acceptance' => true,
        ]);
    }

    // usage: Category::factory()->assetDisplayCategory();
    public function assetDisplayCategory()
    {
        return Category::factory()->create([
            'name' => 'Displays',
            'category_type' => 'asset',
        ]);
    }

     // usage: Category::factory()->assetTabletCategory();
     public function assetTabletCategory()
     {
         return Category::factory()->create([
             'name' => 'Tablets',
             'category_type' => 'asset',
         ]);
     }

     // usage: Category::factory()->assetMobileCategory();
     public function assetMobileCategory()
     {
         return Category::factory()->create([
             'name' => 'Mobile Phones',
             'category_type' => 'asset',
         ]);
     }

     // usage: Category::factory()->assetConferenceCategory();
     public function assetConferenceCategory()
     {
         return Category::factory()->create([
             'name' => 'Conference Phones',
             'category_type' => 'asset',
         ]);
     }


     // usage: Category::factory()->assetVoipCategory();
     public function assetVoipCategory()
     {
         return Category::factory()->create([
             'name' => 'VOIP Phones',
             'category_type' => 'asset',
         ]);
     }

     // usage: Category::factory()->accessoryKeyboardCategory();
     public function accessoryKeyboardCategory()
     {
         return Category::factory()->create([
             'name' => 'Keyboardss',
             'category_type' => 'accessory',
         ]);
     }


     // usage: Category::factory()->accessoryMouseCategory();
     public function accessoryMouseCategory()
     {
         return Category::factory()->create([
             'name' => 'Mouse',
             'category_type' => 'accessory',
         ]);
     }

     // usage: Category::factory()->componentHddCategory();
     public function componentHddCategory()
     {
         return Category::factory()->create([
             'name' => 'HDD/SSD',
             'category_type' => 'component',
         ]);
     }

     // usage: Category::factory()->componentRamCategory();
     public function componentRamCategory()
     {
         return Category::factory()->create([
             'name' => 'RAM',
             'category_type' => 'component',
         ]);
     }

     // usage: Category::factory()->consumablePaperCategory();
     public function consumablePaperCategory()
     {
         return Category::factory()->create([
             'name' => 'Printer Paper',
             'category_type' => 'consumable',
         ]);
     }

     // usage: Category::factory()->consumableInkCategory();
     public function consumableInkCategory()
     {
         return Category::factory()->create([
             'name' => 'Printer Ink',
             'category_type' => 'consumable',
         ]);
     }

     // usage: Category::factory()->licenseGraphicsCategory();
     public function licenseGraphicsCategory()
     {
         return Category::factory()->create([
             'name' => 'Graphics Software',
             'category_type' => 'license',
         ]);
     }

     // usage: Category::factory()->licenseGraphicsCategory();
     public function licenseOfficeCategory()
     {
         return Category::factory()->create([
             'name' => 'Office Software',
             'category_type' => 'license',
         ]);
     }

}
