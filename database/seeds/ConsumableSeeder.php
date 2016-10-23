<?php
use Illuminate\Database\Seeder;
use App\Models\Consumable;

class ConsumableSeeder extends Seeder
{
  public function run()
  {
    Consumable::truncate();
    factory(Consumable::class, 'consumable',25)->create();
  }
}
