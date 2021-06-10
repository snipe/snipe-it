<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;


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
            'checkin_email' => $this->faker->boolean(),
            'eula_text' => $this->faker->paragraph(),
            'require_acceptance' => false,
            'use_default_eula' => $this->faker->boolean(),
            'user_id' => 1,
        ];
    }

    public function assetLaptopCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Laptops',
                'category_type' => 'asset',
                'require_acceptance' => true,
            ];
        });
    }

    public function assetDesktopCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Desktops',
                'category_type' => 'asset',
            ];
        });
    }

    public function assetDisplayCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Displays',
                'category_type' => 'asset',
            ];
        });
    }

    public function assetTabletCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Tablets',
                'category_type' => 'asset',
            ];
        });
    }

    public function assetMobileCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Mobile Phones',
                'category_type' => 'asset',
            ];
        });
    }

    public function assetConferenceCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Conference Phones',
                'category_type' => 'asset',
            ];
        });
    }

    public function assetVoipCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'VOIP Phones',
                'category_type' => 'asset',
            ];
        });
    }

    public function accessoryKeyboardCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Keyboards',
                'category_type' => 'accessory',
            ];
        });
    }

    public function accessoryMouseCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Mouse',
                'category_type' => 'accessory',
            ];
        });
    }

    public function componentHddCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'HDD/SSD',
                'category_type' => 'component',
            ];
        });
    }

    public function componentRamCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'RAM',
                'category_type' => 'component',
            ];
        });
    }

    public function consumablePaperCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Printer Paper',
                'category_type' => 'consumable',
            ];
        });
    }

    public function consumableInkCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Printer Ink',
                'category_type' => 'consumable',
            ];
        });
    }

    public function licenseGraphicsCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Graphics Software',
                'category_type' => 'license',
            ];
        });
    }

    public function licenseOfficeCategory()
    {
        return $this->state(function () {
            return [
                'name' => 'Office Software',
                'category_type' => 'license',
            ];
        });
    }
}
