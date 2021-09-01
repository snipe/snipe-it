<?php

/*
|--------------------------------------------------------------------------
| Components Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating components ..
|
*/

$factory->define(App\Models\Component::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'order_number' => $faker->numberBetween(1000000, 50000000),
        'purchase_date' => $faker->dateTimeBetween('-1 years','now', date_default_timezone_get()),
        'purchase_cost' => $faker->randomFloat(2, 1, 50),
        'qty' => $faker->numberBetween(5, 10),
        'min_amt' => $faker->numberBetween($min = 1, $max = 2),
    ];
});

$factory->state(App\Models\Component::class, 'ram-crucial4', function ($faker) {

    return [
        'name' => 'Crucial 4GB DDR3L-1600 SODIMM',
        'category_id' => 13,
        'qty' => 10,
        'min_amt' => 2,
        'location_id' => 3,
        'company_id' => 2
    ];
});

$factory->state(App\Models\Component::class, 'ram-crucial8', function ($faker) {

    return [
        'name' => 'Crucial 8GB DDR3L-1600 SODIMM Memory for Mac',
        'category_id' => 13,
        'qty' => 10,
        'min_amt' => 2
    ];
});

$factory->state(App\Models\Component::class, 'ssd-crucial120', function ($faker) {

    return [
        'name' => 'Crucial BX300 120GB SATA Internal SSD',
        'category_id' => 12,
        'qty' => 10,
        'min_amt' => 2
    ];
});

$factory->state(App\Models\Component::class, 'ssd-crucial240', function ($faker) {

    return [
        'name' => 'Crucial BX300 240GB SATA Internal SSD',
        'category_id' => 12,
        'qty' => 10,
        'min_amt' => 2
    ];
});



