<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;

class ComponentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Component::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'category_id' => Category::factory(),
            'location_id' => Location::factory(),
            'serial'   => $this->faker->uuid(),
            'qty' => $this->faker->numberBetween(3, 10),
            'order_number' => $this->faker->numberBetween(1000000, 50000000),
            'purchase_date' => $this->faker->dateTime()->format('Y-m-d'),
            'purchase_cost' => $this->faker->randomFloat(2),
            'min_amt' => $this->faker->numberBetween($min = 1, $max = 2),
            'company_id' => Company::factory(),
            'supplier_id' => Supplier::factory(),
        ];
    }

    public function ramCrucial4()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial 4GB DDR3L-1600 SODIMM',
                'category_id' => function () {
                    return Category::where('name', 'RAM')->first() ?? Category::factory()->componentRamCategory();
                },
                'qty' => 10,
                'min_amt' => 2,
                'location_id' => Location::factory(),
            ];
        });
    }

    public function ramCrucial8()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial 8GB DDR3L-1600 SODIMM Memory for Mac',
                'category_id' => function () {
                    return Category::where('name', 'RAM')->first() ?? Category::factory()->componentRamCategory();
                },
                'qty' => 10,
                'min_amt' => 2,
            ];
        });
    }

    public function ssdCrucial120()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial BX300 120GB SATA Internal SSD',
                'category_id' => function () {
                    return Category::where('name', 'HDD/SSD')->first() ?? Category::factory()->componentHddCategory();
                },
                'qty' => 10,
                'min_amt' => 2,
            ];
        });
    }

    public function ssdCrucial240()
    {
        return $this->state(function () {
            return [
                'name' => 'Crucial BX300 240GB SATA Internal SSD',
                'category_id' => function () {
                    return Category::where('name', 'HDD/SSD')->first() ?? Category::factory()->componentHddCategory();
                },
                'qty' => 10,
                'min_amt' => 2,
            ];
        });
    }


}
