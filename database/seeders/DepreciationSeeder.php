<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Depreciation;

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
