<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

class AccessoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Accessory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin();
            },
            'model_number' => $this->faker->numberBetween(1000000, 50000000),
            'location_id' => rand(1, 5),
        ];
    }

    public function appleBtKeyboard()
    {
        return $this->state(function () {
            return [
                'name' => 'Bluetooth Keyboard',
                'image' => 'bluetooth.jpg',
                'category_id' => function () {
                    return Category::where('name', 'Keyboardss')->first() ?? Category::factory()->accessoryKeyboardCategory();
                },
                'manufacturer_id' => function () {
                    return Manufacturer::where('name', 'Apple')->first() ?? Manufacturer::factory()->apple();
                },
                'qty' => 10,
                'min_amt' => 2,
                'supplier_id' => rand(1, 5),
            ];
        });
    }

    public function appleUsbKeyboard()
    {
        return $this->state(function () {
            return [
                'name' => 'USB Keyboard',
                'image' => 'usb-keyboard.jpg',
                'category_id' => function () {
                    return Category::where('name', 'Keyboardss')->first() ?? Category::factory()->accessoryKeyboardCategory();
                },
                'manufacturer_id' => function () {
                    return Manufacturer::where('name', 'Apple')->first() ?? Manufacturer::factory()->apple();
                },
                'qty' => 15,
                'min_amt' => 2,
                'supplier_id' => rand(1, 5),
            ];
        });
    }

    public function appleMouse()
    {
        return $this->state(function () {
            return [
                'name' => 'Magic Mouse',
                'image' => 'magic-mouse.jpg',
                'category_id' => function () {
                    return Category::where('name', 'Mouse')->first() ?? Category::factory()->accessoryMouseCategory();
                },
                'manufacturer_id' => function () {
                    return Manufacturer::where('name', 'Apple')->first() ?? Manufacturer::factory()->apple();
                },
                'qty' => 13,
                'min_amt' => 2,
                'supplier_id' => rand(1, 5),
            ];
        });
    }

    public function microsoftMouse()
    {
        return $this->state(function () {
            return [
                'name' => 'Sculpt Comfort Mouse',
                'image' => 'comfort-mouse.jpg',
                'category_id' => function () {
                    return Category::where('name', 'Mouse')->first() ?? Category::factory()->accessoryMouseCategory();
                },
                'manufacturer_id' => function () {
                    return Manufacturer::where('name', 'Microsoft')->first() ?? Manufacturer::factory()->microsoft();
                },
                'qty' => 13,
                'min_amt' => 2,
            ];
        });
    }
}
