<?php

use App\Models\Asset;

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
        'name' => $faker->catchPhrase,
        'model_id' => function () {
            return factory(App\Models\AssetModel::class)->create()->id;
        },
        'rtd_location_id' => function () {
            return factory(App\Models\Location::class)->create()->id;
        },
        'serial' => $faker->uuid,
        'status_id' => function () {
            return factory(App\Models\Statuslabel::class)->create()->id;
        },
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'asset_tag' => $faker->unixTime('now'),
        'notes'   => $faker->sentence,
        'purchase_date' => $faker->dateTime(),
        'purchase_cost' => $faker->randomFloat(2),
        'order_number' => $faker->numberBetween(1000000, 50000000),
        'supplier_id' => function () {
            return factory(App\Models\Supplier::class)->create()->id;
        },
        'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
        },
        'requestable' => $faker->boolean()
    ];
});

$factory->state(Asset::class, 'deleted', function($faker) {
    return [
        'deleted_at' => $faker->dateTime(),
    ];
});

$factory->state(Asset::class, 'assigned-to-user', function ($faker) {
    return [
        'assigned_to' => factory(App\Models\User::class)->create()->id,
        'assigned_type' => App\Models\User::class,
    ];
});

$factory->state(Asset::class, 'assigned-to-location', function ($faker) {
    return [
        'assigned_to' => factory(App\Models\Location::class)->create()->id,
        'assigned_type' => App\Models\Location::class,
    ];
});

$factory->state(Asset::class, 'assigned-to-asset', function ($faker) {
    return [
        'assigned_to' => factory(App\Models\Asset::class)->create()->id,
        'assigned_type' => App\Models\Asset::class,
    ];
});


$factory->define(App\Models\AssetModel::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->catchPhrase,
    'manufacturer_id' => function () {
        return factory(App\Models\Manufacturer::class)->create()->id;
    },
    'category_id' => function () {
        return factory(App\Models\Category::class)->states('asset-category')->create()->id;
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
