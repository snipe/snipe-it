<?php

namespace Database\Seeders;

use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentSeeder extends Seeder
{
    public function run()
    {
        Component::truncate();
        DB::table('components_assets')->truncate();
        Component::factory()->count(1)->ramCrucial4()->create(); // 1
        Component::factory()->count(1)->ramCrucial8()->create(); // 1
        Component::factory()->count(1)->ssdCrucial120()->create(); // 1
        Component::factory()->count(1)->ssdCrucial240()->create(); // 1
    }
}
