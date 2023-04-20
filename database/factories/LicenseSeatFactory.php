<?php

namespace Database\Factories;

use App\Models\License;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseSeatFactory extends Factory
{
    public function definition()
    {
        return [
            'license_id' => License::factory(),
        ];
    }
}
