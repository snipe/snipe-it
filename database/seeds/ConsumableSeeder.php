<?php
use Illuminate\Database\Seeder;
use App\Models\Consumable;

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
