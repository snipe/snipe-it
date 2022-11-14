<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

// 1

// 2

// 3

// 4

class LicenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\License::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {


        return [
            'user_id' => 1,
            'name' => $this->faker->name,
            'license_email' => $this->faker->safeEmail,
            'serial' => $this->faker->uuid,
            'notes'   => 'Created by DB seeder',
            'seats' => $this->faker->numberBetween(1, 10),
            'purchase_date' => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
            'order_number' => $this->faker->numberBetween(1000000, 50000000),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+3 years', date_default_timezone_get())->format('Y-m-d H:i:s'),
            'reassignable' => $this->faker->boolean(),
            'termination_date' => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get())->format('Y-m-d H:i:s'),
            'supplier_id' => $this->faker->numberBetween(1, 5),
            'category_id' => Category::where('category_type', '=', 'license')->inRandomOrder()->first()->id
        ];
    }

    public function photoshop()
    {
        return $this->state(function () {
            $data = [
                'name' => 'Photoshop',
                'manufacturer_id' => 9,
                'purchase_cost' => '299.99',
                'seats' => 10,
                'purchase_order' => '13503Q',
                'maintained' => true,
                'category_id' => 14,
            ];

            return $data;
        });
    }

    public function acrobat()
    {
        return $this->state(function () {
            $data = [
                'name' => 'Acrobat',
                'manufacturer_id' => 9,
                'purchase_cost' => '29.99',
                'seats' => 10,
                'category_id' => 14,
            ];

            return $data;
        });
    }

    public function indesign()
    {
        return $this->state(function () {
            $data = [
                'name' => 'InDesign',
                'manufacturer_id' => 9,
                'purchase_cost' => '199.99',
                'seats' => 10,
                'category_id' => 14,
            ];
    

            return $data;
        });
    }

    public function office()
    {
        return $this->state(function () {
            $data = [
                'name' => 'Office',
                'manufacturer_id' => 2,
                'purchase_cost' => '49.99',
                'seats' => 20,
                'category_id' => 15,
            ];

            return $data;
        });
    }
}
