<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\Supplier;


$factory->define(App\Models\Company::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->company,
    ];
});

$factory->define(App\Models\Component::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(20),
        'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
        },
        'location_id' => 1,
        'serial'   => $faker->uuid,
        'qty' => $faker->numberBetween(3, 10),
        'order_number' => $faker->numberBetween(1000000, 50000000),
        'purchase_date' => $faker->dateTime(),
        'purchase_cost' => $faker->randomFloat(2),
        'min_amt' => $faker->numberBetween($min = 1, $max = 2),
        'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
        },
    ];
});


$factory->define(App\Models\Location::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->city,
    'address' => $faker->streetAddress,
    'address2' => $faker->secondaryAddress,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'country' => $faker->countryCode,
    'currency' => $faker->currencyCode,
    'zip' => $faker->postcode,
    'image' => rand(1,9).'.jpg',
    ];
});


$factory->define(App\Models\Supplier::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->company,
    'address' => $faker->streetAddress,
    'address2' => $faker->secondaryAddress,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'zip' => $faker->postCode,
    'country' => $faker->countryCode,
    'contact' => $faker->name,
    'phone' => $faker->phoneNumber,
    'fax'   => $faker->phoneNumber,
    'email' => $faker->safeEmail,
    'url'   => $faker->url,
    'notes' => $faker->text(191) // Supplier notes can be a max of 255 characters.
    ];
});

$factory->define(App\Models\Setting::class, function ($faker) {
    return [
        'user_id' => 1,
        'per_page' => 20,
        'site_name' => $faker->sentence,
        'auto_increment_assets' => false,
        'alert_email' => $faker->safeEmail(),
        'alerts_enabled' => true,
        'brand' => 1,
        'default_currency' => $faker->currencyCode,
        'locale' => $faker->locale,
        'pwd_secure_min' => 10, // Match web setup
    ];
});
