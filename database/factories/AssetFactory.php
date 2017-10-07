<?php

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to modelling assets.
|
*/

$factory->define(Asset::class, function (Faker\Generator $faker) {
    return [
        'name' => null,
        'rtd_location_id' => 1,
        'serial' => $faker->uuid,
        'status_id' => 1,
        'user_id' => 1,
        'asset_tag' => $faker->unixTime('now'),
        'notes'   => $faker->sentence,
        'purchase_date' => $faker->dateTime(),
        'purchase_cost' => $faker->randomFloat(2),
        'order_number' => $faker->numberBetween(1000000, 50000000),
        'supplier_id' => 1,
        'company_id' => 1,
        'requestable' => $faker->boolean()
    ];
});




$factory->state(Asset::class, 'asset-laptop', function ($faker) {
    return [
        'model_id' => 1
    ];
});

$factory->define(App\Models\AssetModel::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->catchPhrase,
    'manufacturer_id' => function () {
        return factory(App\Models\Manufacturer::class)->create()->id;
    },
    'category_id' => function () {
        return factory(App\Models\Category::class)->states('asset-desktop-category')->create()->id;
    },
    'model_number' => $faker->numberBetween(1000000, 50000000),
    'eol' => 1,
    'notes' => $faker->paragraph(),
    'requestable' => $faker->boolean(),
    'depreciation_id' => function () {
        return factory(App\Models\Depreciation::class)->create()->id;
    },
    ];
});

$factory->define(App\Models\AssetMaintenance::class, function (Faker\Generator $faker) {
    return [
        'asset_id' => function () {
            return factory(App\Models\Asset::class)->create()->id;
        },
        'supplier_id' => function () {
            return factory(App\Models\Supplier::class)->create()->id;
        },
        'asset_maintenance_type' => $faker->randomElement(['maintenance', 'repair', 'upgrade']),
        'title' => $faker->sentence,
        'start_date' => $faker->date(),
        'is_warranty' => $faker->boolean(),
        'notes' => $faker->paragraph(),
    ];
});
