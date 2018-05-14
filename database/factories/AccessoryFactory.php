<?php

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

$factory->define(App\Models\Accessory::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'model_number' => $faker->numberBetween(1000000, 50000000),
        'location_id' => rand(1,5),
    ];
});

$factory->state(App\Models\Accessory::class, 'apple-bt-keyboard', function ($faker) {

    return [
        'name' => 'Bluetooth Keyboard',
        'category_id' => 8,
        'manufacturer_id' => 1,
        'qty' => 10,
        'min_amt' => 2,
        'supplier_id' => rand(1,5)
    ];

});

$factory->state(App\Models\Accessory::class, 'apple-usb-keyboard', function ($faker) {

    return [
        'name' => 'USB Keyboard',
        'category_id' => 8,
        'manufacturer_id' => 1,
        'qty' => 15,
        'min_amt' => 2,
        'supplier_id' => rand(1,5)
    ];

});

$factory->state(App\Models\Accessory::class, 'apple-mouse', function ($faker) {

    return [
        'name' => 'Magic Mouse',
        'category_id' => 9,
        'manufacturer_id' => 1,
        'qty' => 13,
        'min_amt' => 2,
        'supplier_id' => rand(1,5)
    ];

});

$factory->state(App\Models\Accessory::class, 'microsoft-mouse', function ($faker) {

    return [
        'name' => 'Sculpt Comfort Mouse',
        'category_id' => 9,
        'manufacturer_id' => 2,
        'qty' => 13,
        'min_amt' => 2
    ];

});

