<?php

namespace Database\Factories;

use App\Models\CustomField;
use App\Models\CustomFieldset;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomFieldsetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomFieldset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase(),
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

    public function complicated()
    {
        //$mac = CustomField::factory()->macAddress()->create();
        return $this->state(function () {
            return [
                'name' => 'complicated'
            ];
        })  ->hasAttached(CustomField::factory()->macAddress(),['required' => false, 'order' => 0],'fields')
            ->hasAttached(CustomField::factory()->plainText(),['required' => true,'order' => 1],'fields')
            ->hasAttached(CustomField::factory()->date(),['required' => false, 'order' => 2],'fields');
    }
}
