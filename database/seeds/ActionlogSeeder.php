<?php
use Illuminate\Database\Seeder;
use App\Models\Actionlog;

class ActionlogSeeder extends Seeder
{
  public function run()
  {
    Actionlog::truncate();
    factory(Actionlog::class, 'asset-checkout',5)->create();
  }
}
