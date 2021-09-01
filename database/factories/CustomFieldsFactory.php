<?php


$factory->define(App\Models\CustomField::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->catchPhrase,
    'format' => '',
    'element' => 'text',
    ];
});

$factory->state(App\Models\CustomField::class, 'imei', function ($faker) {
    return [
        'name' => 'IMEI',
        'help_text' => 'The IMEI number for this device.',
        'format' => 'regex:/^[0-9]{15}$/',
    ];
});

$factory->state(App\Models\CustomField::class, 'phone', function ($faker) {
    return [
        'name' => 'Phone Number',
        'help_text' => 'Enter the phone number for this device.',
    ];
});

$factory->state(App\Models\CustomField::class, 'ram', function ($faker) {
    return [
        'name' => 'RAM',
        'help_text' => 'The amount of RAM this device has.',
    ];
});

$factory->state(App\Models\CustomField::class, 'cpu', function ($faker) {
    return [
        'name' => 'CPU',
        'help_text' => 'The speed of the processor on this device.',
    ];
});


$factory->state(App\Models\CustomField::class, 'mac-address', function ($faker) {
    return [
        'name' => 'MAC Address',
        'format' => 'regex:/^([0-9a-fA-F]{2}[:-]){5}[0-9a-fA-F]{2}$/',
    ];
});

