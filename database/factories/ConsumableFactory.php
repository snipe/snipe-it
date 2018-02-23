<?php

/*
|--------------------------------------------------------------------------
| Consumables Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating consumables ..
|
*/

$factory->define(App\Models\Consumable::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'item_no' => $faker->numberBetween(1000000, 50000000),
        'order_number' => $faker->numberBetween(1000000, 50000000),
        'purchase_date' => $faker->dateTimeBetween('-1 years','now', date_default_timezone_get()),
        'purchase_cost' => $faker->randomFloat(2, 1, 50),
        'qty' => $faker->numberBetween(5, 10),
        'min_amt' => $faker->numberBetween($min = 1, $max = 2),
    ];
});

$factory->state(App\Models\Consumable::class, 'cardstock', function ($faker) {

    return [
        'name' => 'Cardstock (White)',
        'category_id' => 10,
        'manufacturer_id' => 10,
        'qty' => 10,
        'min_amt' => 2,
        'company_id' => 3
    ];
});

$factory->state(App\Models\Consumable::class, 'paper', function ($faker) {

    return [
        'name' => 'Laserjet Paper (Ream)',
        'category_id' => 10,
        'manufacturer_id' => 10,
        'qty' => 20,
        'min_amt' => 2
    ];
});

$factory->state(App\Models\Consumable::class, 'ink', function ($faker) {

    return [
        'name' => 'Laserjet Toner (black)',
        'category_id' => 11,
        'manufacturer_id' => 5,
        'qty' => 20,
        'min_amt' => 2
    ];
});



