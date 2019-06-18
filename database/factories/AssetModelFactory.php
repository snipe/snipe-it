<?php

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

/*
|--------------------------------------------------------------------------
| Laptops
|--------------------------------------------------------------------------
*/
$factory->define(App\Models\AssetModel::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'model_number' => $faker->creditCardNumber(),
        'notes' => 'Created by demo seeder',

    ];
});


// 1
$factory->state(App\Models\AssetModel::class, 'mbp-13-model', function ($faker) {
    return [
        'name' => 'Macbook Pro 13"',
        'category_id' => 1,
        'manufacturer_id' => 1,
        'eol' => '36',
        'depreciation_id' => 1,
        'image' => 'mbp.jpg',
    ];
});

// 2
$factory->state(App\Models\AssetModel::class, 'mbp-air-model', function ($faker) {
    return [
        'name' => 'Macbook Air',
        'category_id' => 1,
        'manufacturer_id' => 1,
        'eol' => '36',
        'depreciation_id' => 1,
        'image' => 'macbookair.jpg',
    ];
});

// 3
$factory->state(App\Models\AssetModel::class, 'surface-model', function ($faker) {
    return [
        'name' => 'Surface',
        'category_id' => 1,
        'manufacturer_id' => 2,
        'eol' => '36',
        'depreciation_id' => 1,
        'image' => 'surface.jpg',
    ];
});

// 4
$factory->state(App\Models\AssetModel::class, 'xps13-model', function ($faker) {
    return [
        'name' => 'XPS 13',
        'category_id' => 1,
        'manufacturer_id' => 3,
        'eol' => '36',
        'depreciation_id' => 1,
        'image' => 'xps.jpg',
    ];
});

// 5
$factory->state(App\Models\AssetModel::class, 'zenbook-model', function ($faker) {
    return [
        'name' => 'ZenBook UX310',
        'category_id' => 1,
        'manufacturer_id' => 4,
        'eol' => '36',
        'depreciation_id' => 1,
        'image' => 'zenbook.jpg',
    ];
});

// 6
$factory->state(App\Models\AssetModel::class, 'spectre-model', function ($faker) {
    return [
        'name' => 'Spectre',
        'category_id' => 1,
        'manufacturer_id' => 5,
        'eol' => '36',
        'depreciation_id' => 1,
        'image' => 'spectre.jpg',
    ];
});

// 7
$factory->state(App\Models\AssetModel::class, 'yoga-model', function ($faker) {
    return [
        'name' => 'Yoga 910',
        'category_id' => 1,
        'manufacturer_id' => 6,
        'eol' => '36',
        'depreciation_id' => 1,
        'image' => 'yoga.png',
    ];
});

/*
|--------------------------------------------------------------------------
| Desktops
|--------------------------------------------------------------------------
*/


$factory->state(App\Models\AssetModel::class, 'macpro-model', function ($faker) {
    return [
        'name' => 'iMac Pro',
        'category_id' => 2,
        'manufacturer_id' => 1,
        'eol' => '24',
        'depreciation_id' => 1,
        'image' => 'imacpro.jpg',
    ];
});

$factory->state(App\Models\AssetModel::class, 'lenovo-i5-model', function ($faker) {
    return [
        'name' => 'Lenovo Intel Core i5',
        'category_id' => 2,
        'manufacturer_id' => 6,
        'eol' => '24',
        'depreciation_id' => 1,
        'image' => 'lenovoi5.png',
    ];
});

$factory->state(App\Models\AssetModel::class, 'optiplex-model', function ($faker) {
    return [
        'name' => 'OptiPlex',
        'category_id' => 2,
        'manufacturer_id' => 3,
        'model_number' => '5040 (MRR81)',
        'eol' => '24',
        'depreciation_id' => 1,
        'image' => 'optiplex.jpg',
    ];
});


/*
|--------------------------------------------------------------------------
| Conference Phones
|--------------------------------------------------------------------------
*/


$factory->state(App\Models\AssetModel::class, 'polycom-model', function ($faker) {
    return [
        'name' => 'SoundStation 2',
        'category_id' => 6,
        'manufacturer_id' => 8,
        'eol' => '12',
        'depreciation_id' => 1,
        'image' => 'soundstation.jpg',
    ];
});

$factory->state(App\Models\AssetModel::class, 'polycomcx-model', function ($faker) {
    return [
        'name' => 'Polycom CX3000 IP Conference Phone',
        'category_id' => 6,
        'manufacturer_id' => 8,
        'eol' => '12',
        'depreciation_id' => 1,
        'image' => 'cx3000.png',
    ];
});


/*
|--------------------------------------------------------------------------
| Tablets
|--------------------------------------------------------------------------
*/

$factory->state(App\Models\AssetModel::class, 'ipad-model', function ($faker) {
    return [
        'name' => 'iPad Pro',
        'category_id' => 3,
        'manufacturer_id' => 1,
        'eol' => '12',
        'depreciation_id' => 1,
        'image' => 'ipad.jpg',
    ];
});


$factory->state(App\Models\AssetModel::class, 'tab3-model', function ($faker) {
    return [
        'name' => 'Tab3',
        'category_id' => 3,
        'manufacturer_id' => 6,
        'eol' => '12',
        'depreciation_id' => 1,
        'image' => 'tab3.png',
    ];
});


/*
|--------------------------------------------------------------------------
| Mobile Phones
|--------------------------------------------------------------------------
*/

$factory->state(App\Models\AssetModel::class, 'iphone6s-model', function ($faker) {
    return [
        'name' => 'iPhone 6s',
        'category_id' => 4,
        'manufacturer_id' => 1,
        'eol' => '12',
        'depreciation_id' => 3,
        'image' => 'iphone6.jpg',
    ];
});

$factory->state(App\Models\AssetModel::class, 'iphone7-model', function ($faker) {
    return [
        'name' => 'iPhone 7',
        'category_id' => 4,
        'manufacturer_id' => 1,
        'eol' => '12',
        'depreciation_id' => 1,
        'image' => 'iphone7.jpg',
    ];
});

/*
|--------------------------------------------------------------------------
| Displays
|--------------------------------------------------------------------------
*/

$factory->state(App\Models\AssetModel::class, 'ultrafine', function ($faker) {
    return [
        'name' => 'Ultrafine 4k',
        'category_id' => 5,
        'manufacturer_id' => 7,
        'eol' => '12',
        'depreciation_id' => 2,
        'image' => 'ultrafine.jpg',
    ];
});

$factory->state(App\Models\AssetModel::class, 'ultrasharp', function ($faker) {
    return [
        'name' => 'Ultrasharp U2415',
        'category_id' => 5,
        'manufacturer_id' => 3,
        'eol' => '12',
        'depreciation_id' => 2,
        'image' => 'ultrasharp.jpg',
    ];
});






