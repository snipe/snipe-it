<?php
use Illuminate\Database\Seeder;
use App\Models\Consumable;

class ConsumableSeeder extends Seeder
{
    public function run()
    {
        Consumable::truncate();
        factory(Consumable::class, 25)->create();
    }
}
