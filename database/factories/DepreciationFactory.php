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

class DepreciationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Depreciation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase(),
            'user_id' => 1,
            'months' => 36,
        ];
    }

    public function computer()
    {
        return $this->state(function () {
            return [
                'name' => 'Computer Depreciation',
                'months' => 36,
            ];
        });
    }

    public function display()
    {
        return $this->state(function () {
            return [
                'name' => 'Display Depreciation',
                'months' => 12,
            ];
        });
    }

    public function mobilePhones()
    {
        return $this->state(function () {
            return [
                'name' => 'Mobile Phone Depreciation',
                'months' => 24,
            ];
        });
    }
}
