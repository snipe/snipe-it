<?php

namespace Database\Factories;

use App\Models\Depreciation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepreciationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Depreciation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->catchPhrase(),
            'created_by' => User::factory()->superuser(),
            'term_length' => 365,
            'term_type' => 'days',
        ];
    }

    public function computer()
    {
        return $this->state(function () {
            return [
                'name' => 'Computer Depreciation',
                'term_length' => 36,
                'term_type' => 'months',
            ];
        });
    }

    public function display()
    {
        return $this->state(function () {
            return [
                'name' => 'Display Depreciation',
                'term_length' => 36,
                'term_type' => 'months',
            ];
        });
    }

    public function mobilePhones()
    {
        return $this->state(function () {
            return [
                'name' => 'Mobile Phone Depreciation',
                'term_length' => 365,
                'term_type' => 'days',
            ];
        });
    }
}
