<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\CustomField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase,
            'format' => '',
            'element' => 'text',
        ];
    }

    public function imei()
    {
        return $this->state(function () {
            return [
                'name' => 'IMEI',
                'help_text' => 'The IMEI number for this device.',
                'format' => 'regex:/^[0-9]{15}$/',
            ];
        });
    }

    public function phone()
    {
        return $this->state(function () {
            return [
                'name' => 'Phone Number',
                'help_text' => 'Enter the phone number for this device.',
            ];
        });
    }

    public function ram()
    {
        return $this->state(function () {
            return [
                'name' => 'RAM',
                'help_text' => 'The amount of RAM this device has.',
            ];
        });
    }

    public function cpu()
    {
        return $this->state(function () {
            return [
                'name' => 'CPU',
                'help_text' => 'The speed of the processor on this device.',
            ];
        });
    }

    public function macAddress()
    {
        return $this->state(function () {
            return [
                'name' => 'MAC Address',
                'format' => 'regex:/^([0-9a-fA-F]{2}[:-]){5}[0-9a-fA-F]{2}$/',
            ];
        });
    }
}
