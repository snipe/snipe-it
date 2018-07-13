<?php

use App\Models\Statuslabel;

$factory->define(Statuslabel::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->sentence,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
        'user_id' => 1,
        'deleted_at' => null,
        'deployable' => 0,
        'pending' => 0,
        'archived' => 0,
        'notes' => ''
    ];
});
$factory->state(Statuslabel::class, 'rtd', function (Faker\Generator $faker) {
    return [
        'notes' => $faker->sentence,
        'deployable' => 1,
        'default_label' => 1,
    ];
});
$factory->state(Statuslabel::class, 'pending', function (Faker\Generator $faker) {
    return [
        'notes' => $faker->sentence,
        'pending' => 1,
        'default_label' => 1,
    ];
});

$factory->state(Statuslabel::class, 'archived', function (Faker\Generator $faker) {
    return [
        'notes' => 'These assets are permanently undeployable',
        'archived' => 1,
        'default_label' => 0,
    ];
});

$factory->state(Statuslabel::class, 'out_for_diagnostics', function (Faker\Generator $faker) {
    return [
        'name' => 'Out for Diagnostics',
        'default_label' => 0,
    ];
});

$factory->state(Statuslabel::class, 'out_for_repair', function (Faker\Generator $faker) {
    return [
        'name'      => 'Out for Repair',
        'default_label' => 0,
    ];
});

$factory->state(Statuslabel::class, 'broken', function (Faker\Generator $faker) {
    return [
        'name'      => 'Broken - Not Fixable',
        'default_label' => 0,
    ];
});

$factory->state(Statuslabel::class, 'lost', function (Faker\Generator $faker) {
    return [
        'name'      => 'Lost/Stolen',
        'default_label' => 0,
    ];
});
