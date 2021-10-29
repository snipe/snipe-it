<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFieldsetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\CustomFieldset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase,
        ];
    }

    public function mobile()
    {
        return $this->state(function () {
            return [
                'name' => 'Mobile Devices',
            ];
        });
    }

    public function computer()
    {
        return $this->state(function () {
            return [
                'name' => 'Laptops and Desktops',
            ];
        });
    }
}
