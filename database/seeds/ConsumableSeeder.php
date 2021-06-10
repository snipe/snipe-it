<?php

use App\Models\Consumable;
use Illuminate\Database\Seeder;

class ConsumableSeeder extends Seeder
{
    public function run()
    {
        Consumable::truncate();
        DB::table('consumables_users')->truncate();
        factory(Consumable::class, 1)->states('cardstock')->create(); // 1
        factory(Consumable::class, 1)->states('paper')->create(); // 2
        factory(Consumable::class, 1)->states('ink')->create(); // 3
    }
}
