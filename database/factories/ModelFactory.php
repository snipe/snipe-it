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

$factory->define(App\Models\Accessory::class, function (Faker\Generator $faker) {
    return [
    'company_id' => function () {
        return factory(App\Models\Company::class)->create()->id;
    },
    'name' => $faker->text(20),
    'category_id' => function () {
        return factory(App\Models\Category::class)->states('accessory-category')->create()->id;
    },
    'manufacturer_id' => function () {
        return factory(App\Models\Manufacturer::class)->create()->id;
    },
    'location_id' => function () {
        return factory(App\Models\Location::class)->create()->id;
    },
    'order_number' => $faker->numberBetween(1000000, 50000000),
    'purchase_date' => $faker->dateTime(),
    'purchase_cost' => $faker->randomFloat(2),
    'qty' => $faker->numberBetween(5, 10),
    'min_amt' => $faker->numberBetween($min = 1, $max = 2),
    ];
});

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
        'location_id' => function () {
            return factory(App\Models\Location::class)->create()->id;
        },
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

$factory->define(App\Models\Consumable::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->text(20),
    'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
    },
    'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
    },
    'location_id' => function () {
            return factory(App\Models\Location::class)->create()->id;
    },
    'manufacturer_id' => function () {
        return factory(App\Models\Manufacturer::class)->create()->id;
    },
    'user_id' => function () {
        return factory(App\Models\User::class)->create()->id;
    },
    'model_number' => $faker->numberBetween(1000000, 50000000),
    'item_no' => $faker->numberBetween(1000000, 50000000),
    'order_number' => $faker->numberBetween(1000000, 50000000),
    'purchase_date' => $faker->dateTime(),
    'purchase_cost' => $faker->randomFloat(2),
    'qty' => $faker->numberBetween(5, 10),
    'min_amt' => $faker->numberBetween($min = 1, $max = 2),
    ];
});

$factory->define(App\Models\CustomField::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->catchPhrase,
    'format' => 'IP',
    'element' => 'text',
    ];
});

$factory->define(App\Models\Department::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->catchPhrase,
    'user_id' => '1',
    'location_id' => function () {
        return factory(App\Models\Location::class)->create()->id;
    },
    'company_id' => function () {
        return factory(App\Models\Company::class)->create()->id;
    },
    'manager_id' => function () {
        return factory(App\Models\User::class)->create()->id;
    },

    ];
});

$factory->define(App\Models\Depreciation::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->text(20),
    'months' => $faker->numberBetween(1, 10),
    ];
});

$factory->define(App\Models\License::class, function (Faker\Generator $faker) {
    return [
    'name'   => $faker->catchPhrase,
    'serial'   => $faker->uuid,
    'seats'   => $faker->numberBetween(1, 10),
    'license_email'   => $faker->safeEmail,
    'license_name'   => $faker->name,
    'order_number' => $faker->numberBetween(1500, 13250),
    'purchase_order' => $faker->numberBetween(1500, 13250),
    'purchase_date' => $faker->dateTime(),
    'purchase_cost' => $faker->randomFloat(2),
    'notes' => $faker->sentence,
    'supplier_id' => function () {
        return factory(App\Models\Supplier::class)->create()->id;
    },
    'company_id' =>function () {
        return factory(App\Models\Company::class)->create()->id;
    },
    ];
});

$factory->define(App\Models\LicenseSeat::class, function (Faker\Generator $faker) {
    return [
    'license_id' => function () {
        return factory(App\Models\License::class)->create()->id;
    },
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'notes' => $faker->sentence,
    'user_id' => '1',
    ];
});

$factory->define(App\Models\Location::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->catchPhrase,
    'address' => $faker->streetAddress,
    'address2' => $faker->secondaryAddress,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'country' => $faker->countryCode,
    'currency' => $faker->currencyCode,
    'zip' => $faker->postcode
    ];
});

$factory->define(App\Models\Manufacturer::class, function (Faker\Generator $faker) {
    return [
    'name' => $faker->company,
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
    'notes' => $faker->text(255) // Supplier notes can be a max of 255 characters.
    ];
});

$factory->define(App\Models\Setting::class, function ($faker) {
    return [
        'user_id' => 1,
        'per_page' => 20,
        'site_name' => $faker->sentence,
        'auto_increment_assets' => false,
        'alert_email' => $faker->safeEmail(),
        'alerts_enabled' => false,
        'brand' => 1,
        'default_currency' => $faker->currencyCode,
        'locale' => $faker->locale,
        'pwd_secure_min' => 5,
    ];
});
