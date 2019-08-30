<?php
use Illuminate\Database\Seeder;
use App\Models\Accessory;


class AccessorySeeder extends Seeder
{
  public function run()
  {
      Accessory::truncate();
      DB::table('accessories_users')->truncate();
      factory(Accessory::class, 1)->states('apple-usb-keyboard')->create();
      factory(Accessory::class, 1)->states('apple-bt-keyboard')->create();
      factory(Accessory::class, 1)->states('apple-mouse')->create();
      factory(Accessory::class, 1)->states('microsoft-mouse')->create();
  }
}
