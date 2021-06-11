<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

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

    /**
     * HR dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deptHr()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Human Resources',
            ];
        });
    }

    /**
     * Engineering dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deptEngineering()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Engineering',
            ];
        });
    }

    /**
     * Marketing dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deptMarketing()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Marketing',
            ];
        });
    }

    /**
     * Client Services dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deptClientServices()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Client Services',
            ];
        });
    }

    /**
     * Product dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deptProduct()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Product Services',
            ];
        });
    }

    /**
     * Silly Walks dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deptSillyWalks()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Dept of Silly Walks',
            ];
        });
    }
}
