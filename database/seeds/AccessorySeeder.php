<?php
use Illuminate\Database\Seeder;
use App\Models\Accessory;

class AccessorySeeder extends Seeder
{
  public function run()
  {
    Accessory::truncate();
    factory(Accessory::class,15)->create();
  }
}
