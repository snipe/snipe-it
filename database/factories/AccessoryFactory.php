<?php

namespace Database\Factories;

use App\Models\Accessory;
use App\Models\Category;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Accessory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => sprintf(
                '%s %s',
                $this->faker->randomElement(['Bluetooth', 'Wired']),
                $this->faker->randomElement(['Keyboard', 'Wired'])
            ),
            'user_id' => User::factory()->superuser(),
            'category_id' => Category::factory(),
            'model_number' => $this->faker->numberBetween(1000000, 50000000),
            'location_id' => Location::factory(),
            'qty' => 1,
        ];
    }

    public function appleBtKeyboard()
    {
        return $this->state(function () {
            return [
                'name' => 'Bluetooth Keyboard',
                'image' => 'bluetooth.jpg',
                'category_id' => function () {
                    return Category::where('name', 'Keyboards')->first() ?? Category::factory()->accessoryKeyboardCategory();
                },
                'manufacturer_id' => function () {
                    return Manufacturer::where('name', 'Apple')->first() ?? Manufacturer::factory()->apple();
                },
                'qty' => 10,
                'min_amt' => 2,
                'supplier_id' => Supplier::factory(),
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
                    return Category::where('name', 'Keyboards')->first() ?? Category::factory()->accessoryKeyboardCategory();
                },
                'manufacturer_id' => function () {
                    return Manufacturer::where('name', 'Apple')->first() ?? Manufacturer::factory()->apple();
                },
                'qty' => 15,
                'min_amt' => 2,
                'supplier_id' => Supplier::factory(),
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
                'supplier_id' => Supplier::factory(),
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
