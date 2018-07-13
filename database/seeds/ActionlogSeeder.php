<?php
use Illuminate\Database\Seeder;
use App\Models\Actionlog;

class ActionlogSeeder extends Seeder
{
  public function run()
  {
    Actionlog::truncate();
      factory(Actionlog::class, 'asset-checkout-user',300)->create();
      factory(Actionlog::class, 'asset-checkout-location',100)->create();
  }
}
