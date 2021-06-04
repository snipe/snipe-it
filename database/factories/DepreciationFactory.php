<?php
namespace Database\Factories;

use App\Models\Depreciation;
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
            'user_id' => 1,
        ];

    }

    /**
     * Computers
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function depreciateComputer()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Computers',
                'months' => '24',
            ];
        });
    }

    /**
     * Engineering dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function depreciateDisplay()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Displays',
                'months' => '36',
            ];
        });
    }

    /**
     * Marketing dept
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function depreciateMobile()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Mobile Devices',
                'months' => '12',
            ];
        });
    }




}


