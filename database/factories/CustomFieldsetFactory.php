<?php


$factory->define(App\Models\CustomFieldset::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->catchPhrase,
    ];
});

$factory->state(App\Models\CustomFieldset::class, 'mobile', function ($faker) {
    return [
        'name' => 'Mobile Devices',
    ];
});

$factory->state(App\Models\CustomFieldset::class, 'computer', function ($faker) {
    return [
        'name' => 'Laptops and Desktops',
    ];
});



