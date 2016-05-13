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

$factory->defineAs(App\Models\Asset::class, 'asset', function (Faker\Generator $faker) {
  return [
    'name' => $faker->catchPhrase,
    'model_id' => $faker->numberBetween(1,5),
    'rtd_location_id' => $faker->numberBetween(1,5),
    'serial' => $faker->uuid,
    'status_id' => 1,
    'user_id' => 1,
    'asset_tag' => $faker->unixTime('now'),
    'notes'   => $faker->sentence,
    'purchase_date' 		=> $faker->dateTime(),
    'order_number' => $faker->numberBetween(1000000,50000000),
    'supplier_id' => $faker->numberBetween(1,5),
    'requestable' => $faker->numberBetween(0,1),
  ];
});


$factory->defineAs(App\Models\AssetModel::class, 'assetmodel', function (Faker\Generator $faker) {
  return [
    'name' => $faker->catchPhrase,
    'manufacturer_id' => $faker->numberBetween(1,10),
    'category_id' => $faker->numberBetween(1,9),
    'modelno' => $faker->numberBetween(1000000,50000000),
    'eol' => 1,
  ];
});

$factory->defineAs(App\Models\Location::class, 'location', function (Faker\Generator $faker) {
  return [
    'name' => $faker->city,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'country' => $faker->countryCode,
    'currency' => $faker->currencyCode,
  ];
});

$factory->defineAs(App\Models\Category::class, 'asset-category', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'category_type' => $faker->randomElement($array = array ('asset')),
  ];
});

$factory->defineAs(App\Models\Category::class, 'accessory-category', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'category_type' => $faker->randomElement($array = array ('accessory')),
  ];
});

$factory->defineAs(App\Models\Category::class, 'component-category', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'category_type' => $faker->randomElement($array = array ('component')),
  ];
});

$factory->defineAs(App\Models\Category::class, 'consumable-category', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'category_type' => $faker->randomElement($array = array ('consumable')),
  ];
});


$factory->defineAs(App\Models\Company::class, 'company', function (Faker\Generator $faker) {
  return [
    'name' => $faker->company,
  ];
});

$factory->defineAs(App\Models\Manufacturer::class, 'manufacturer', function (Faker\Generator $faker) {
  return [
    'name' => $faker->company,
  ];
});

$factory->defineAs(App\Models\Component::class, 'component', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'category_id' => $faker->numberBetween(21,25),
    'total_qty' => $faker->numberBetween(3, 10),
    'min_amt' => $faker->numberBetween($min = 1, $max = 2),
  ];
});

$factory->defineAs(App\Models\Depreciation::class, 'depreciation', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'months' => $faker->numberBetween(1, 10),
  ];
});

$factory->defineAs(App\Models\Accessory::class, 'accessory', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'category_id' => $faker->numberBetween(11,15),
    'qty' => $faker->numberBetween(5, 10),
    'location_id' => $faker->numberBetween(1,5),
    'min_amt' => $faker->numberBetween($min = 1, $max = 2),
  ];
});


$factory->defineAs(App\Models\Supplier::class, 'supplier', function (Faker\Generator $faker) {
  return [
    'name' => $faker->company,
    'address' => $faker->streetAddress,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'country' => $faker->countryCode,
    'contact' => $faker->name,
    'phone' => $faker->phoneNumber,
    'email' => $faker->safeEmail,
  ];
});


$factory->defineAs(App\Models\Consumable::class, 'consumable', function (Faker\Generator $faker) {
  return [
    'name' => $faker->text(20),
    'category_id' => $faker->numberBetween(16, 20),
    'company_id' => $faker->numberBetween(1, 10),
    'qty' => $faker->numberBetween(5, 10),
    'min_amt' => $faker->numberBetween($min = 1, $max = 2),

  ];
});


$factory->defineAs(App\Models\Statuslabel::class, 'rtd', function (Faker\Generator $faker) {
  return [
    'name'      => 'Ready to Deploy',
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'user_id' => 1,
    'deleted_at' 		=> NULL,
    'deployable'	=> 1,
    'pending'	=> 0,
    'archived' => 0,
    'notes' => ''
  ];
});

$factory->defineAs(App\Models\Statuslabel::class, 'pending', function (Faker\Generator $faker) {
  return [
    'name'  => 'Pending',
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'user_id' => 1,
    'deleted_at' 		=> NULL,
    'deployable'	=> 0,
    'pending'	=> 1,
    'archived' => 0,
    'notes' => ''
  ];
});

$factory->defineAs(App\Models\Statuslabel::class, 'archived', function (Faker\Generator $faker) {
  return [
    'name'      => 'Archived',
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'user_id' => 1,
    'deleted_at' 		=> NULL,
    'deployable'	=> 0,
    'pending'	=> 0,
    'archived' => 1,
    'notes' => 'These assets are permanently undeployable'
  ];
});

$factory->defineAs(App\Models\Statuslabel::class, 'out_for_diagnostics', function (Faker\Generator $faker) {
  return [
    'name' => 'Out for Diagnostics',
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'user_id' => 1,
    'deleted_at' 		=> NULL,
    'deployable'	=> 0,
    'pending'	=> 0,
    'archived' => 0,
    'notes' => ''
  ];
});

$factory->defineAs(App\Models\Statuslabel::class, 'out_for_repair', function (Faker\Generator $faker) {
  return [
    'name'      => 'Out for Repair',
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'user_id' => 1,
    'deleted_at' 		=> NULL,
    'deployable'	=> 0,
    'pending'	=> 0,
    'archived' => 0,
    'notes' => ''
  ];
});

$factory->defineAs(App\Models\Statuslabel::class, 'broken', function (Faker\Generator $faker) {
  return [
    'name'      => 'Broken - Not Fixable',
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'user_id' => 1,
    'deleted_at' 		=> NULL,
    'deployable'	=> 0,
    'pending'	=> 0,
    'archived' => 1,
     'notes' => ''
  ];
});

$factory->defineAs(App\Models\Statuslabel::class, 'lost', function (Faker\Generator $faker) {
  return [
    'name'      => 'Lost/Stolen',
    'created_at' => $faker->dateTime(),
    'updated_at' => $faker->dateTime(),
    'user_id' => 1,
    'deleted_at' 		=> NULL,
    'deployable'	=> 0,
    'pending'	=> 0,
    'archived' => 1,
    'notes' => '',
  ];
});

$factory->defineAs(App\Models\License::class, 'license', function (Faker\Generator $faker) {
  return [
    'name'   => $faker->catchPhrase,
    'serial'   => $faker->uuid,
    'seats'   => $faker->numberBetween(1, 10),
    'license_email'   => $faker->safeEmail,
    'license_name'   => $faker->name,
    'purchase_date' 		=> $faker->dateTime(),
    'purchase_cost' 		=> $faker->randomFloat(2),
    'notes'   => $faker->sentence,
  ];
});

$factory->defineAs(App\Models\LicenseSeat::class, 'license-seat', function (Faker\Generator $faker) {
  return [
    'license_id'      	=> $faker->numberBetween(1, 10),
    'created_at' 		=> $faker->dateTime(),
    'updated_at' 		=> $faker->dateTime(),
    'notes' 			=> $faker->sentence,
    'user_id' 			=> '1',
  ];
});

$factory->defineAs(App\Models\Actionlog::class, 'asset-checkout', function (Faker\Generator $faker) {
  return [
    'user_id'      	=> 1,
    'action_type' 		=> 'checkout',
    'asset_id' 		=> $faker->numberBetween(1, 10),
    'checkedout_to' => 1,
    'created_at'  => $faker->dateTime(),
    'asset_type'  => 'hardware',
    'note' 			=> $faker->sentence,
    'user_id' 			=> '1',
  ];
});


$factory->defineAs(App\Models\CustomField::class, 'customfield-ip', function (Faker\Generator $faker) {
  return [
    'name' => $faker->catchPhrase,
    'format' => 'IP',
    'element' => 'text',
  ];
});


$factory->defineAs(App\Models\User::class, 'valid-user', function (Faker\Generator $faker) {
  return [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->safeEmail,
    'password' => $faker->password,
    'username' => $faker->username,
  ];
});
