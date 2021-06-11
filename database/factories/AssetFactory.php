<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     *  @return array
     */
    public function definition()
    {
        return [
            'name' => null,
            'rtd_location_id' => rand(1, 10),
            'serial' => $this->faker->uuid,
            'status_id' => 1,
            'user_id' => 1,
            'asset_tag' => $this->faker->unixTime('now'),
            'notes'   => 'Created by DB seeder',
            'purchase_date' => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
            'purchase_cost' => $this->faker->randomFloat(2, '299.99', '2999.99'),
            'order_number' => $this->faker->numberBetween(1000000, 50000000),
            'supplier_id' => 1,
            'requestable' => $this->faker->boolean(),
            'assigned_to' => null,
            'assigned_type' => null,
            'next_audit_date' => null,
            'last_checkout' => null,
        ];
    }

    /**
     * Laptop category
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetLaptopMbp()
    {
        return $this->state(function (array $attributes) {
            return [
                'model_id' => 1,
            ];
        });
    }
}
