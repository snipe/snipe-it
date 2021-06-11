<?php

namespace Database\Seeders;

use App\Models\Depreciation;
use Illuminate\Database\Seeder;

class DepreciationSeeder extends Seeder
{
    public function run()
    {
        Depreciation::truncate();
        Depreciation::factory()->count(1)->depreciateComputer()->create();
        Depreciation::factory()->count(1)->depreciateDisplay()->create();
        Depreciation::factory()->count(1)->depreciateMobile()->create();
    }
}
