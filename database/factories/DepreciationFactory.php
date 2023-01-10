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
            'term_length' => 36,
            'term_type' => 'months'
        ];
    }

    public function computer()
    {
        return $this->state(function () {
            return [
                'name' => 'Computer Depreciation',
                'term_length' => 36,
                'term_type' => 'months'
            ];
        });
    }

    public function display()
    {
        return $this->state(function () {
            return [
                'name' => 'Display Depreciation',
                'term_length' => 12,
                'term_type' => 'months'
            ];
        });
    }

    public function mobilePhones()
    {
        return $this->state(function () {
            return [
                'name' => 'Mobile Phone Depreciation',
                'term_length' => 24,
                'term_type' => 'months'
            ];
        });
    }

    public function mobilePhonesv2()
    {
        return $this->state(function () {
            return [
                'name' => 'Mobile Phone Depreciation by Days',
                'term_length' => 730,
                'term_type' => 'days'
            ];
        });
    }
}
