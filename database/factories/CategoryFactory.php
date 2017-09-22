<?php

/*
|--------------------------------------------------------------------------
| Category Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating categories and the various states..
|
*/


$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->text(20),
    'category_type' => $faker->randomElement(['asset', 'accessory', 'component', 'consumable']),
    'eula_text' => $faker->paragraph(),
    'require_acceptance' => false,
    'use_default_eula' => $faker->boolean(),
    'checkin_email' => $faker->boolean()
    ];
});

$factory->state(App\Models\Category::class, 'asset-category', function ($faker) {
    return [
        'category_type' => 'asset',
    ];
});

$factory->state(App\Models\Category::class, 'accessory-category', function ($faker) {
    return [
        'category_type' => 'accessory',
    ];
});

$factory->state(App\Models\Category::class, 'component-category', function ($faker) {
    return [
        'category_type' => 'component',
    ];
});

$factory->state(App\Models\Category::class, 'consumable-category', function ($faker) {
    return [
        'category_type' => 'consumable',
    ];
});

$factory->state(App\Models\Category::class, 'requires-acceptance', function ($faker) {
    return [
        'require_acceptance' => true,
    ];
});
