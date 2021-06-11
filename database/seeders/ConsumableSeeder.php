<?php

namespace Database\Seeders;

use App\Models\Consumable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsumableSeeder extends Seeder
{
    public function run()
    {
        Consumable::truncate();
        DB::table('consumables_users')->truncate();
        Consumable::factory()->count(1)->cardstock()->create(); // 1
        Consumable::factory()->count(1)->paper()->create(); // 2
        Consumable::factory()->count(1)->ink()->create(); // 3
    }
}
