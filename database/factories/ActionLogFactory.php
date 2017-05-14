<?php

use App\Models\Actionlog;

// Conveninece function for action logs.
// Expects an array with the following Keys:
// 'company' => company associated with everything
// 'user' => user performing the action
// 'target' => target of the action
// 'item' => object action is being performed upon
// 'action_type' => checkin, checkout, etc
$checkout = function ($values) {
    return [
        'user_id' => $values['user']->id,
        'action_type' => $values['action_type'],
        'item_id' => $values['item']->id,
        'item_type'  => get_class($values['item']),
        'target_id' => $values['target']->id,
        'target_type' => get_class($target),
        'created_at'  => $faker->dateTime(),
        'note' => $faker->sentence,
        'company_id' => $values['company']->id,
    ];
};

$factory->defineAs(Actionlog::class, 'asset-checkout', function (Faker\Generator $faker) {
    $values = [
        'company' => factory(App\Models\Company::class)->create(),
        'user' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'target' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'item' => factory(App\Models\Asset::class)->create(['company_id' => $company->id]),
    ];

    return $checkout($values);
});

$factory->defineAs(Actionlog::class, 'license-checkout-asset', function (Faker\Generator $faker) {
    $values = [
        'company' => factory(App\Models\Company::class)->create(),
        'user' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'target' => factory(App\Models\Asset::class)->create(['company_id' => $company->id]),
        'item' => factory(App\Models\License::class)->create(['company_id' => $company->id]),
    ];

    return $checkout($values);
});

$factory->defineAs(Actionlog::class, 'accessory-checkout', function (Faker\Generator $faker) {
    $values = [
        'company' => factory(App\Models\Company::class)->create(),
        'user' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'target' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'item' => factory(App\Models\Accessory::class)->create(['company_id' => $company->id]),
    ];

    return $checkout($values);
});

$factory->defineAs(Actionlog::class, 'consumable-checkout', function (Faker\Generator $faker) {

    $values = [
        'company' => factory(App\Models\Company::class)->create(),
        'user' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'target' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'item' => factory(App\Models\Consumable::class)->create(['company_id' => $company->id]),
    ];

    return $checkout($values);
});

$factory->defineAs(Actionlog::class, 'component-checkout', function (Faker\Generator $faker) {

    $values = [
        'company' => factory(App\Models\Company::class)->create(),
        'user' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'target' => factory(App\Models\User::class)->create(['company_id' => $company->id]),
        'item' => factory(App\Models\Component::class)->create(['company_id' => $company->id]),
    ];

    return $checkout($values);
});
