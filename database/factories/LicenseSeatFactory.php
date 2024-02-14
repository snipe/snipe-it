<?php

namespace Database\Factories;

use App\Models\License;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseSeatFactory extends Factory
{
    public function definition()
    {
        return [
            'license_id' => License::factory(),
        ];
    }

    public function assignedToUser(User $user = null)
    {
        return $this->state(function () use ($user) {
            return [
                'assigned_to' => $user->id ?? User::factory(),
            ];
        });
    }
}
