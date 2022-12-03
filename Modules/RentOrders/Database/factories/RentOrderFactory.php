<?php

namespace Modules\RentOrders\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\RentOrders\Entities\RentOrder;

class RentOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RentOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "create_by" => function () {
                return \App\Models\User::factory()->create()->id;
            },
            "assigned_to" => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ];
    }
}

