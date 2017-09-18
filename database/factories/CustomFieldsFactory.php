<?php


$factory->define(App\Models\CustomField::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->catchPhrase,
    'format' => 'IP',
    'element' => 'text',
    ];
});

$factory->define(App\Models\CustomFieldset::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->catchPhrase,
        'user_id' => Auth::id()
    ];
});
