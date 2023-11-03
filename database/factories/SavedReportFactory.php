<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SavedReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'options' => json_encode([]),
        ];
    }
}
