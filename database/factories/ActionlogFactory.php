<?php

namespace Database\Factories;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/*
|--------------------------------------------------------------------------
| Action Log Factories
|--------------------------------------------------------------------------
|
| This simulates checkin/checkout/etc activities 
|
*/

class ActionlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Actionlog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $asset = \App\Models\Asset::factory()->create();
        return [
            'item_type' => get_class($asset),
            'item_id' => 1,
            'user_id' => 1,
            'action_type' => 'uploaded',
        ];
    }


    public function assetCheckoutToUser()
    {
        return $this->state(function () {
            $target = \App\Models\User::inRandomOrder()->first();
            $item = \App\Models\Asset::RTD()->inRandomOrder()->first();
            $user_id = rand(1, 2); // keep it simple - make it one of the two superadmins
            $asset = Asset::where('id', $item->id)
                ->update(
                    [
                        'assigned_to' => $target->id,
                        'assigned_type' => \App\Models\User::class,
                        'assigned_to' => $target->location_id,
                    ]
                );
    
            return [
                'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
                'user_id' => $user_id,
                'action_type' => 'checkout',
                'item_id' => $item->id,
                'item_type'  => \App\Models\Asset::class,
                'target_id' => $target->id,
                'target_type' => get_class($target),
    
            ];
        });
    }


    public function assetCheckoutToLocation()
    {
        return $this->state(function () {
            $target = \App\Models\Location::inRandomOrder()->first();
            $item = \App\Models\Asset::inRandomOrder()->RTD()->first();
            $user_id = rand(1, 2); // keep it simple - make it one of the two superadmins
            $asset = \App\Models\Asset::where('id', $item->id)
                ->update(
                    [
                        'assigned_to' => $target->id,
                        'assigned_type' => \App\Models\Location::class,
                        'assigned_to' => $target->id,
                    ]
                );

            return [
                'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
                'user_id' => $user_id,
                'action_type' => 'checkout',
                'item_id' => $item->id,
                'item_type'  => \App\Models\Asset::class,
                'target_id' => $target->id,
                'target_type' => get_class($target),
            ];
        });
    }


}
