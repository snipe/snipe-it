<?php

namespace Database\Seeders;

use App\Models\Depreciation;
use Illuminate\Database\Seeder;

class DepreciationSeeder extends Seeder
{
    public function run()
    {
        Depreciation::truncate();
        Depreciation::factory()->count(1)->computer()->create(); // 1
        Depreciation::factory()->count(1)->display()->create(); // 2
        Depreciation::factory()->count(1)->mobilePhones()->create(); // 3
    }
}
