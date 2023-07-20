<?php

namespace Database\Factories;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActionlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Actionlog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => Asset::factory(),
            'item_type' => Asset::class,
            'user_id' => User::factory()->superuser(),
            'action_type' => 'uploaded',
        ];
    }

    public function assetCheckoutToUser()
    {
        return $this->state(function () {
            $target = User::inRandomOrder()->first();
            $asset = Asset::RTD()->inRandomOrder()->first();

            $asset->update(
                    [
                        'assigned_to' => $target->id,
                        'assigned_type' => User::class,
                        'location_id' => $target->location_id,
                    ]
                );
    
            return [
                'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
                'action_type' => 'checkout',
                'item_id' => $asset->id,
                'item_type'  => Asset::class,
                'target_id' => $target->id,
                'target_type' => User::class,
            ];
        });
    }

    public function assetCheckoutToLocation()
    {
        return $this->state(function () {
            $target = Location::inRandomOrder()->first();
            $asset = Asset::inRandomOrder()->RTD()->first();

            $asset->update(
                    [
                        'assigned_to' => $target->id,
                        'assigned_type' => Location::class,
                        'location_id' => $target->id,
                    ]
                );

            return [
                'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
                'action_type' => 'checkout',
                'item_id' => $asset->id,
                'item_type'  => Asset::class,
                'target_id' => $target->id,
                'target_type' => Location::class,
            ];
        });
    }

    public function licenseCheckoutToUser()
    {
        return $this->state(function () {
            $target = User::inRandomOrder()->first();
            $licenseSeat = LicenseSeat::whereNull('assigned_to')->inRandomOrder()->first();

            $licenseSeat->update([
                'assigned_to' => $target->id,
                'user_id' => 1, // not ideal but works
            ]);

            return [
                'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
                'action_type' => 'checkout',
                'item_id' => $licenseSeat->license->id,
                'item_type'  => License::class,
                'target_id' => $target->id,
                'target_type' => User::class,
            ];
        });
    }
}
