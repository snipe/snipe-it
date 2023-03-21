<?php

namespace Database\Seeders;

use App\Models\Depreciation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepreciationSeeder extends Seeder
{
    public function run()
    {
        Depreciation::truncate();

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        Depreciation::factory()->count(1)->computer()->create(['user_id' => $admin->id]);
        Depreciation::factory()->count(1)->display()->create(['user_id' => $admin->id]);
        Depreciation::factory()->count(1)->mobilePhones()->create(['user_id' => $admin->id]);
    }
}
