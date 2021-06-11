<?php

namespace Database\Factories;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActionLogFactory extends Factory
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
            'note' => 'Sample checkout from DB seeder!',
        ];
    }

    /**
     * MBP
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetCheckoutToUser()
    {
        $target = User::inRandomOrder()->first()->first();
        $item = Asset::inRandomOrder()->RTD()->first();
        $user_id = rand(1, 2); // keep it simple - make it one of the two superadmins
        $item->update(
                [
                    'assigned_to' => $target->id,
                    'assigned_type' => App\Models\User::class,
                ]
            );

        return $this->state(function (array $attributes) use ($user_id, $item, $target) {
            return [
                'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
                'user_id' => $user_id,
                'action_type' => 'checkout',
                'item_id' => $item->id,
                'item_type'  => App\Models\Asset::class,
                'target_id' => $target->id,
                'target_type' => get_class($target),
            ];
        });
    }

    /**
     * Macbook Air
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function assetCheckoutToLocation()
    {
        $target = Location::inRandomOrder()->first();
        $item = Asset::inRandomOrder()->RTD()->first();

        $user_id = rand(1, 2); // keep it simple - make it one of the two superadmins
        $item->update(
                [
                    'assigned_to' => $target->id,
                    'assigned_type' => Location::class,
                ]
            );

        return $this->state(function (array $attributes) use ($user_id, $item, $target) {
            return [
                'created_at'  => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get()),
                'user_id' => $user_id,
                'action_type' => 'checkout',
                'item_id' => $item->id,
                'item_type'  => App\Models\Asset::class,
                'target_id' => $target->id,
                'target_type' => get_class($target),
            ];
        });
    }
}
