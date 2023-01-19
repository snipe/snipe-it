<?php

namespace Database\Factories;

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
            'user_id' => 1,
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
                'category_id' => 8,
                'manufacturer_id' => 1,
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
                'category_id' => 8,
                'manufacturer_id' => 1,
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
                'category_id' => 9,
                'manufacturer_id' => 1,
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
                'category_id' => 9,
                'manufacturer_id' => 2,
                'qty' => 13,
                'min_amt' => 2,
            ];
        });
    }
}
