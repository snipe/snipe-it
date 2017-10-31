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
        'rtd_location_id' => rand(1,10),
        'serial' => $faker->uuid,
        'status_id' => 1,
        'user_id' => 1,
        'asset_tag' => $faker->unixTime('now'),
        'notes'   => 'Created by DB seeder',
        'purchase_date' => $faker->dateTimeBetween('-1 years','now', date_default_timezone_get()),
        'purchase_cost' => $faker->randomFloat(2, '299.99', '2999.99'),
        'order_number' => $faker->numberBetween(1000000, 50000000),
        'supplier_id' => 1,
        'requestable' => $faker->boolean()
    ];
});




$factory->state(Asset::class, 'laptop-mbp', function ($faker) {
    return [
        'model_id' => 1
    ];
});

$factory->state(Asset::class, 'laptop-mbp-pending', function ($faker) {
    return [
        'model_id' => 1,
         'status_id' => 2,
    ];
});

$factory->state(Asset::class, 'laptop-mbp-archived', function ($faker) {
    return [
        'model_id' => 1,
        'status_id' => 3,
    ];
});

$factory->state(Asset::class, 'laptop-air', function ($faker) {
    return [
        'model_id' => 2
    ];
});

$factory->state(Asset::class, 'laptop-surface', function ($faker) {
    return [
        'model_id' => 3
    ];
});

$factory->state(Asset::class, 'laptop-xps', function ($faker) {
    return [
        'model_id' => 4
    ];
});

$factory->state(Asset::class, 'laptop-spectre', function ($faker) {
    return [
        'model_id' => 5
    ];
});

$factory->state(Asset::class, 'laptop-zenbook', function ($faker) {
    return [
        'model_id' => 6
    ];
});

$factory->state(Asset::class, 'laptop-yoga', function ($faker) {
    return [
        'model_id' => 7
    ];
});

$factory->state(Asset::class, 'desktop-macpro', function ($faker) {
    return [
        'model_id' => 8
    ];
});

$factory->state(Asset::class, 'desktop-lenovo-i5', function ($faker) {
    return [
        'model_id' => 9
    ];
});

$factory->state(Asset::class, 'desktop-optiplex', function ($faker) {
    return [
        'model_id' => 10
    ];
});

$factory->state(Asset::class, 'conf-polycom', function ($faker) {
    return [
        'model_id' => 11
    ];
});

$factory->state(Asset::class, 'conf-polycomcx', function ($faker) {
    return [
        'model_id' => 12
    ];
});

$factory->state(Asset::class, 'tablet-ipad', function ($faker) {
    return [
        'model_id' => 13
    ];
});

$factory->state(Asset::class, 'tablet-tab3', function ($faker) {
    return [
        'model_id' => 14
    ];
});

$factory->state(Asset::class, 'phone-iphone6s', function ($faker) {
    return [
        'model_id' => 15
    ];
});

$factory->state(Asset::class, 'phone-iphone7', function ($faker) {
    return [
        'model_id' => 16
    ];
});

$factory->state(Asset::class, 'ultrafine', function ($faker) {
    return [
        'model_id' => 17
    ];
});

$factory->state(Asset::class, 'ultrasharp', function ($faker) {
    return [
        'model_id' => 18
    ];
});


// These are just for unit tests, not to generate data

$factory->state(Asset::class, 'assigned-to-user', function ($faker) {
    return [
        'model_id' => 1,
        'assigned_to' => factory(App\Models\User::class)->create()->id,
        'assigned_type' => App\Models\User::class,
    ];
});
$factory->state(Asset::class, 'assigned-to-location', function ($faker) {
    return [
        'model_id' => 1,
        'assigned_to' => factory(App\Models\Location::class)->create()->id,
        'assigned_type' => App\Models\Location::class,
    ];
});
$factory->state(Asset::class, 'assigned-to-asset', function ($faker) {
    return [
        'model_id' => 1,
        'assigned_to' => factory(App\Models\Asset::class)->create()->id,
        'assigned_type' => App\Models\Asset::class,
    ];
});

$factory->state(Asset::class, 'requires-acceptance', function ($faker) {
    return [
        'model_id' => 1,
    ];
});


$factory->state(Asset::class, 'deleted', function ($faker) {
    return [
        'model_id' => 1,
        'deleted_at' => $faker->dateTime()
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
