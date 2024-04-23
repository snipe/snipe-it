<?php

namespace Database\Factories;

use App\Models\CustomFieldset;
use App\Models\CustomField;
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
            'name' => $this->faker->unique()->catchPhrase(),
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

    public function hasEncryptedCustomField(CustomField $field = null)
    {
        return $this->afterCreating(function (CustomFieldset $fieldset) use ($field) {
            $field = $field ?? CustomField::factory()->testEncrypted()->create();

            $fieldset->fields()->attach($field, ['order' => '1', 'required' => false]);
        });
    }
}
