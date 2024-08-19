<?php

namespace Database\Factories;

use App\Models\Asset;
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

    public function assignedToAsset(Asset $asset = null)
    {
        return $this->state(function () use ($asset) {
            return [
                'asset_id' => $asset->id ?? Asset::factory(),
            ];
        });
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
