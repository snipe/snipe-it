<?php

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

$factory->define(App\Models\License::class, function (Faker\Generator $faker) {


    
    $data = [
        'user_id' => 1,
        'location_id' => rand(1,5),
        'serial' => $faker->uuid,
        'notes'   => 'Created by DB seeder',
        'purchase_date' => $faker->dateTimeBetween('-1 years','now', date_default_timezone_get()),
        'order_number' => $faker->numberBetween(1000000, 50000000),
    ];

    for ($x = 0; $x < $data['seats']; $x++) {
        $seat = new LicenseSeat;
        $seat->license_id = 1;
        $seat->save();
    }
    
    return $data;
});

// 1
$factory->state(App\Models\License::class, 'photoshop', function ($faker) {
    return [
        'name' => 'Photoshop',
        'manufacturer_id' => 9,
        'seats' => 10,
    ];
});

// 2
$factory->state(App\Models\License::class, 'acrobat', function ($faker) {
    return [
        'name' => 'Acrobat',
        'manufacturer_id' => 9,
        'seats' => 10,
    ];
});

// 3
$factory->state(App\Models\License::class, 'indesign', function ($faker) {
    return [
        'name' => 'InDesign',
        'manufacturer_id' => 9,
        'seats' => 5,
    ];
});


// 4
$factory->state(App\Models\License::class, 'office', function ($faker) {
    return [
        'name' => 'Office',
        'manufacturer_id' => 2,
        'seats' => 20,
    ];
});


