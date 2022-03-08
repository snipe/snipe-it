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

namespace Database\Factories;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'per_page' => 20,
            'site_name' => $this->faker->sentence,
            'auto_increment_assets' => false,
            'alert_email' => $this->faker->safeEmail(),
            'alerts_enabled' => true,
            'brand' => 1,
            'default_currency' => $this->faker->currencyCode,
            'locale' => 'en',
            'pwd_secure_min' => 10, // Match web setup
            'email_domain' => 'test.com',
        ];
    }
}
