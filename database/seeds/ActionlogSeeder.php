<?php
use Illuminate\Database\Seeder;
use App\Models\Actionlog;

class ActionlogSeeder extends Seeder
{
  public function run()
  {
    Actionlog::truncate();
    factory(Actionlog::class, 'asset-checkout',25)->create();
    factory(Actionlog::class, 'accessory-checkout',15)->create();
    factory(Actionlog::class, 'consumable-checkout', 15)->create();
    factory(Actionlog::class, 'component-checkout', 15)->create();
    factory(Actionlog::class, 'license-checkout-asset', 15)->create();
  }
}
