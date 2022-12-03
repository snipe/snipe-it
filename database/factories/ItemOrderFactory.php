<?php

namespace Database\Factories;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'supplier_id' => Supplier::all()->random()->id,
            'total' => $this->faker->numberBetween(100, 500)
        ];
    }

    public function consumables()
    {
        return $this->state(function () {
            return [
                'item_id' => Consumable::all()->random()->id,
                'item_type' => Consumable::class,
            ];
        });
    }

    public function components()
    {
        return $this->state(function () {
            return [
                'item_id' => Component::all()->random()->id,
                'item_type' => Component::class,
            ];
        });
    }


    public function accesorys()
    {
        return $this->state(function () {
            return [
                'item_id' => Accessory::all()->random()->id,
                'item_type' => Accessory::class,
            ];
        });
    }
}
