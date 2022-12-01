<?php

namespace Database\Factories;

use App\Models\Asset;
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
            'item_id' => Consumable::all()->random()->id,
            'item_type' => PurchaseOrder::CONSUMABLE,
            'supplier_id' => Consumable::all()->random()->id,
            'total' => $this->faker->numberBetween(10000, 50000000)
        ];
    }
}
