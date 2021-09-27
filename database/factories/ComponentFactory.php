<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Components Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating components ..
|
*/

class ComponentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Component::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'category_id' => function () {
                return \App\Models\Category::factory()->create()->id;
            },
            'location_id' => 1,
            'serial'   => $this->faker->uuid,
            'qty' => $this->faker->numberBetween(3, 10),
            'order_number' => $this->faker->numberBetween(1000000, 50000000),
            'purchase_date' => $this->faker->dateTime(),
            'purchase_cost' => $this->faker->randomFloat(2),
            'min_amt' => $this->faker->numberBetween($min = 1, $max = 2),
            'company_id' => function () {
                return \App\Models\Company::factory()->create()->id;
            },
        ];
    }

    public function ramCrucial4()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial 4GB DDR3L-1600 SODIMM',
                'category_id' => 13,
                'qty' => 10,
                'min_amt' => 2,
                'location_id' => 3,
                'company_id' => 2,
            ];
        });
    }

    public function ramCrucial8()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial 8GB DDR3L-1600 SODIMM Memory for Mac',
                'category_id' => 13,
                'qty' => 10,
                'min_amt' => 2,
            ];
        });
    }

    public function ssdCrucial120()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial BX300 120GB SATA Internal SSD',
                'category_id' => 12,
                'qty' => 10,
                'min_amt' => 2,
            ];
        });
    }

    public function ssdCrucial240()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial BX300 240GB SATA Internal SSD',
                'category_id' => 12,
                'qty' => 10,
                'min_amt' => 2,
            ];
        });
    }


}
