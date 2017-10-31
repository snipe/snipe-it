<?php

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

$factory->define(App\Models\Manufacturer::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'support_phone' => $faker->phoneNumber(),
        'url' => $faker->url(),
        'support_email' => $faker->safeEmail(),
    ];
});


// 1
$factory->state(App\Models\Manufacturer::class, 'apple', function ($faker) {
    return [
        'name' => 'Apple',
        'url' => 'https://apple.com',
        'support_url' => 'https://support.apple.com',
        'image' => 'apple.jpg',
    ];
});

// 2
$factory->state(App\Models\Manufacturer::class, 'microsoft', function ($faker) {
    return [
        'name' => 'Microsoft',
        'url' => 'https://microsoft.com',
        'support_url' => 'https://support.microsoft.com',
        'image' => 'microsoft.png',
    ];
});

// 3
$factory->state(App\Models\Manufacturer::class, 'dell', function ($faker) {
    return [
        'name' => 'Dell',
        'url' => 'https://dell.com',
        'support_url' => 'https://support.dell.com',
        'image' => 'dell.png',
    ];
});

// 4
$factory->state(App\Models\Manufacturer::class, 'asus', function ($faker) {
    return [
        'name' => 'Asus',
        'url' => 'https://asus.com',
        'support_url' => 'https://support.asus.com',
        'image' => 'asus.png',
    ];
});

// 5
$factory->state(App\Models\Manufacturer::class, 'hp', function ($faker) {
    return [
        'name' => 'HP',
        'url' => 'https://hp.com',
        'support_url' => 'https://support.hp.com',
        'image' => 'hp.png',
    ];
});

// 6
$factory->state(App\Models\Manufacturer::class, 'lenovo', function ($faker) {
    return [
        'name' => 'Lenovo',
        'url' => 'https://lenovo.com',
        'support_url' => 'https://support.lenovo.com',
        'image' => 'lenovo.jpg',
    ];
});

// 7
$factory->state(App\Models\Manufacturer::class, 'lg', function ($faker) {
    return [
        'name' => 'LG',
        'url' => 'https://lg.com',
        'support_url' => 'https://support.lg.com',
        'image' => 'lg.jpg',
    ];
});

// 8
$factory->state(App\Models\Manufacturer::class, 'polycom', function ($faker) {
    return [
        'name' => 'Polycom',
        'url' => 'https://polycom.com',
        'support_url' => 'https://support.polycom.com',
        'image' => 'polycom.png',
    ];
});

// 9
$factory->state(App\Models\Manufacturer::class, 'adobe', function ($faker) {
    return [
        'name' => 'Adobe',
        'url' => 'https://adobe.com',
        'support_url' => 'https://support.adobe.com',
        'image' => 'adobe.jpg',
    ];
});


// 10
$factory->state(App\Models\Manufacturer::class, 'avery', function ($faker) {
    return [
        'name' => 'Avery',
        'url' => 'https://avery.com',
        'support_url' => 'https://support.avery.com',
        'image' => 'avery.png',
    ];
});

// 11
$factory->state(App\Models\Manufacturer::class, 'crucial', function ($faker) {
    return [
        'name' => 'Crucial',
        'url' => 'https://crucial.com',
        'support_url' => 'https://support.crucial.com',
        'image' => 'crucial.jpg',
    ];
});



