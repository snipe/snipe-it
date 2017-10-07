<?php

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

$factory->define(App\Models\Depreciation::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
    ];
});

$factory->state(App\Models\Depreciation::class, 'computer', function ($faker) {
    return [
        'name' => 'Computer Depreciation',
        'months' => 36,
    ];
});

$factory->state(App\Models\Depreciation::class, 'display', function ($faker) {
    return [
        'name' => 'Display Depreciation',
        'months' => 12,
    ];
});

$factory->state(App\Models\Depreciation::class, 'mobile-phones', function ($faker) {
    return [
        'name' => 'Mobile Phone Depreciation',
        'months' => 24,
    ];
});




