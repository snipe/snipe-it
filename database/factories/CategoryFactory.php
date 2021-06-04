<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;



class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

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

    /**
     * Laptop category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetLaptopCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Laptops',
                'category_type' => 'asset',
                'require_acceptance' => true,
            ];
        });
    }

    /**
     * Desktop category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetDesktopCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Desktops',
                'category_type' => 'asset',
            ];
        });
    }

    /**
     * Tablets category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetTabletCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Tablets',
                'category_type' => 'asset',
            ];
        });
    }

    /**
     * Tablets category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetMobileCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Mobile Phones',
                'category_type' => 'asset',
            ];
        });
    }

    /**
     * Displays category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetDisplayCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Displays',
                'category_type' => 'asset',
            ];
        });
    }

    /**
     * VOIP device category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetVoipCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'VOIP Phones',
                'category_type' => 'asset',
            ];
        });
    }

    /**
     * Conference Phones device category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetConferencePhoneCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Conference Phones',
                'category_type' => 'asset',
            ];
        });
    }

    /**
     * Keyboard category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function accessoryKeyboardCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Keyboards',
                'category_type' => 'accessory',
            ];
        });
    }

    /**
     * Mouse category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function accessoryMouseCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Mouse',
                'category_type' => 'accessory',
            ];
        });
    }

    /**
     * Paper category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function consumablePaperCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Printer Paper',
                'category_type' => 'consumable',
            ];
        });
    }

    /**
     * Printer ink category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function consumableInkCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Printer Ink',
                'category_type' => 'consumable',
            ];
        });
    }

    /**
     * HDD component category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function componentHddCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'HDD',
                'category_type' => 'component',
            ];
        });
    }

    /**
     * RAM component category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function componentRamCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'RAM',
                'category_type' => 'component',
            ];
        });
    }

    /**
     * Graphics software category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function licenseGraphicsCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Graphics Software',
                'category_type' => 'license',
            ];
        });
    }

    /**
     * Office software category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function licenceOfficeCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Office Software',
                'category_type' => 'license',
            ];
        });
    }

}

