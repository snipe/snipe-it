<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Consumables Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating consumables ..
|
*/

class ConsumableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Consumable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'item_no' => $this->faker->numberBetween(1000000, 50000000),
            'order_number' => $this->faker->numberBetween(1000000, 50000000),
            'purchase_date' => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
            'purchase_cost' => $this->faker->randomFloat(2, 1, 50),
            'qty' => $this->faker->numberBetween(5, 10),
            'min_amt' => $this->faker->numberBetween($min = 1, $max = 2),
        ];
    }

    public function cardstock()
    {
        return $this->state(function () {
            return [
                'name' => 'Cardstock (White)',
                'category_id' => 10,
                'manufacturer_id' => 10,
                'qty' => 10,
                'min_amt' => 2,
                'company_id' => 3,
            ];
        });
    }

    public function paper()
    {
        return $this->state(function () {
            return [
                'name' => 'Laserjet Paper (Ream)',
                'category_id' => 10,
                'manufacturer_id' => 10,
                'qty' => 20,
                'min_amt' => 2,
            ];
        });
    }

    public function ink()
    {
        return $this->state(function () {
            return [
                'name' => 'Laserjet Toner (black)',
                'category_id' => 11,
                'manufacturer_id' => 5,
                'qty' => 20,
                'min_amt' => 2,
            ];
        });
    }
}
