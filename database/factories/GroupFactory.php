<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
    ];
});
