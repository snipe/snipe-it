<?php

use App\Models\Actionlog;
use App\Models\Company;
use App\Models\User;
use App\Models\Location;
use App\Models\Asset;


$factory->define(Actionlog::class, function (Faker\Generator $faker) {
    return [
        'note' => 'Sample checkout from DB seeder!',
    ];
});


$factory->defineAs(App\Models\Actionlog::class, 'asset-upload', function ($faker) {
    $asset = factory(App\Models\Asset::class)->create();
    return [
        'item_type' => get_class($asset),
        'item_id' => 1,
        'user_id' => 1,
        'filename' => $faker->word,
        'action_type' => 'uploaded'
    ];
});


$factory->defineAs(Actionlog::class, 'asset-checkout-user', function (Faker\Generator $faker) {
    $target = User::inRandomOrder()->first();
    $item = Asset::inRandomOrder()->RTD()->first();
    $user_id = rand(1,2); // keep it simple - make it one of the two superadmins
    $asset = App\Models\Asset::where('id', $item->id)
        ->update(
            [
                'assigned_to' => $target->id,
                'assigned_type' => App\Models\User::class,
                'assigned_to' => $target->location_id,
            ]
        );

    return [
        'created_at'  => $faker->dateTimeBetween('-1 years','now', date_default_timezone_get()),
        'user_id' => $user_id,
        'action_type' => 'checkout',
        'item_id' => $item->id,
        'item_type'  => App\Models\Asset::class,
        'target_id' => $target->id,
        'target_type' => get_class($target),


    ];
});

$factory->defineAs(Actionlog::class, 'asset-checkout-location', function (Faker\Generator $faker) {
    $target = Location::inRandomOrder()->first();
    $item = Asset::inRandomOrder()->RTD()->first();
    $user_id = rand(1,2); // keep it simple - make it one of the two superadmins
    $asset = App\Models\Asset::where('id', $item->id)
        ->update(
            [
                'assigned_to' => $target->id,
                'assigned_type' => App\Models\Location::class,
                'assigned_to' => $target->id,
            ]
        );

    return [
        'created_at'  => $faker->dateTimeBetween('-1 years','now', date_default_timezone_get()),
        'user_id' => $user_id,
        'action_type' => 'checkout',
        'item_id' => $item->id,
        'item_type'  => App\Models\Asset::class,
        'target_id' => $target->id,
        'target_type' => get_class($target),
    ];
});

// This doesn't work - we need to assign a seat
$factory->defineAs(Actionlog::class, 'license-checkout-asset', function (Faker\Generator $faker) {
    $target = Asset::inRandomOrder()->RTD()->first();
    $item = License::inRandomOrder()->first();
    $user_id = rand(1,2); // keep it simple - make it one of the two superadmins

    return [
        'user_id' => $user_id,
        'action_type' => 'checkout',
        'item_id' => $item->id,
        'item_type'  => get_class($item),
        'target_id' => $target->id,
        'target_type' => get_class($target),
        'created_at'  => $faker->dateTime(),
        'note' => $faker->sentence
    ];
});


$factory->defineAs(Actionlog::class, 'accessory-checkout', function (Faker\Generator $faker) {
    $target = Asset::inRandomOrder()->RTD()->first();
    $item = Accessory::inRandomOrder()->first();
    $user_id = rand(1,2); // keep it simple - make it one of the two superadmins

    return [
        'user_id' => $user_id,
        'action_type' => 'checkout',
        'item_id' => $item->id,
        'item_type'  => get_class($item),
        'target_id' => $target->id,
        'target_type' => get_class($target),
        'created_at'  => $faker->dateTime(),
        'note' => $faker->sentence
    ];
});

$factory->defineAs(Actionlog::class, 'consumable-checkout', function (Faker\Generator $faker) {
    $company =  factory(App\Models\Company::class)->create();
    $user = factory(App\Models\User::class)->create(['company_id' => $company->id]);
    $target = factory(App\Models\User::class)->create(['company_id' => $company->id]);
    $item = factory(App\Models\Consumable::class)->create(['company_id' => $company->id]);

    return [
        'user_id' => $user->id,
        'action_type' => 'checkout',
        'item_id' => $item->id,
        'item_type'  => get_class($item),
        'target_id' => $target->id,
        'target_type' => get_class($target),
        'created_at'  => $faker->dateTime(),
        'note' => $faker->sentence,
        'company_id' => $company->id
    ];
});

$factory->defineAs(Actionlog::class, 'component-checkout', function (Faker\Generator $faker) {
    $company =  factory(App\Models\Company::class)->create();
    $user = factory(App\Models\User::class)->create(['company_id' => $company->id]);
    $target = factory(App\Models\User::class)->create(['company_id' => $company->id]);
    $item = factory(App\Models\Component::class)->create(['company_id' => $company->id]);

    return [
        'user_id' => $user->id,
        'action_type' => 'checkout',
        'item_id' => $item->id,
        'item_type'  => get_class($item),
        'target_id' => $target->id,
        'target_type' => get_class($target),
        'created_at'  => $faker->dateTime(),
        'note' => $faker->sentence,
        'company_id' => $company->id
    ];
});
