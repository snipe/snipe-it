<?php

namespace Database\Factories;

use App\Models\ItemOrder;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Order automatic '.($this->faker->numberBetween(1, 500)),
            'state' => PurchaseOrder::STATES['INITIAL'],
            'user_id' => 1,
            'initial_date' => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get())
        ];
    }

    public function addConsumables() {
        return $this->has(ItemOrder::factory());
    }
    
}
