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

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'location_id' => rand(1, 5),
        ];
    }

    public function hr()
    {
        return $this->state(function () {
            return [
                'name' => 'Human Resources',
            ];
        });
    }

    public function engineering()
    {
        return $this->state(function () {
            return [
                'name' => 'Engineering',
            ];
        });
    }

    public function marketing()
    {
        return $this->state(function () {
            return [
                'name' => 'Marketing',
            ];
        });
    }

    public function client()
    {
        return $this->state(function () {
            return [
                'name' => 'Client Services',
            ];
        });
    }

    public function design()
    {
        return $this->state(function () {
            return [
                'name' => 'Graphic Design',
            ];
        });
    }

    public function product()
    {
        return $this->state(function () {
            return [
                'name' => 'Product Management',
            ];
        });
    }

    public function silly()
    {
        return $this->state(function () {
            return [
                'name' => 'Dept of Silly Walks',
            ];
        });
    }
}
