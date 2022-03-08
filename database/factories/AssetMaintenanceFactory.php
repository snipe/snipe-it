<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to modelling assets.
|
*/

class AssetMaintenanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\AssetMaintenance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'asset_id' => function () {
                return \App\Models\Asset::factory()->create()->id;
            },
            'supplier_id' => function () {
                return \App\Models\Supplier::factory()->create()->id;
            },
            'asset_maintenance_type' => $this->faker->randomElement(['maintenance', 'repair', 'upgrade']),
            'title' => $this->faker->sentence,
            'start_date' => $this->faker->date(),
            'is_warranty' => $this->faker->boolean(),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
