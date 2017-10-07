<?php

/*
|--------------------------------------------------------------------------
| Asset Model Factories
|--------------------------------------------------------------------------
|
| Factories related exclusively to creating models ..
|
*/

$factory->define(App\Models\Department::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'location_id' => rand(1,5),
    ];
});

$factory->state(App\Models\Department::class, 'hr', function ($faker) {
    return [
        'name' => 'Human Resources',
    ];
});

$factory->state(App\Models\Department::class, 'engineering', function ($faker) {
    return [
        'name' => 'Engineering',
    ];
});

$factory->state(App\Models\Department::class, 'marketing', function ($faker) {
    return [
        'name' => 'Marketing',
    ];
});

$factory->state(App\Models\Department::class, 'client', function ($faker) {
    return [
        'name' => 'Client Services',
    ];
});

$factory->state(App\Models\Department::class, 'design', function ($faker) {
    return [
        'name' => 'Graphic Design',
    ];
});

$factory->state(App\Models\Department::class, 'product', function ($faker) {
    return [
        'name' => 'Product Management',
    ];
});

$factory->state(App\Models\Department::class, 'silly', function ($faker) {
    return [
        'name' => 'Dept of Silly Walks',
    ];
});



