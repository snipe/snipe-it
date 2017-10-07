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

    return [
        'user_id' => 1,
        'license_name' => $faker->name,
        'license_email' => $faker->safeEmail,
        'serial' => $faker->uuid,
        'notes'   => 'Created by DB seeder',
        'purchase_date' => $faker->dateTimeBetween('-1 years','now', date_default_timezone_get()),
        'order_number' => $faker->numberBetween(1000000, 50000000),
    ];
});

// 1
$factory->state(App\Models\License::class, 'photoshop', function ($faker) {
    $data =  [
        'name' => 'Photoshop',
        'manufacturer_id' => 9,
        'purchase_cost' => '299.99',
        'seats' => 10,
    ];
    
    return $data;

});

// 2
$factory->state(App\Models\License::class, 'acrobat', function ($faker) {

    $data =  [
        'name' => 'Acrobat',
        'manufacturer_id' => 9,
        'purchase_cost' => '29.99',
        'seats' => 10,
    ];
    

    return $data;
});

// 3
$factory->state(App\Models\License::class, 'indesign', function ($faker) {
    $data =  [
        'name' => 'InDesign',
        'manufacturer_id' => 9,
        'purchase_cost' => '199.99',
        'seats' => 10,
    ];
    

    return $data;
});


// 4
$factory->state(App\Models\License::class, 'office', function ($faker) {
    $data =  [
        'name' => 'Office',
        'manufacturer_id' => 2,
        'purchase_cost' => '49.99',
        'seats' => 20,
    ];


    return $data;
});


