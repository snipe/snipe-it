<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actionlog;

class ActionlogSeeder extends Seeder
{
  public function run()
  {
        Actionlog::truncate();
        Actionlog::factory()->count(100)->assetCheckoutToUser()->create();
        //Actionlog::factory()->count(100)->assetCheckoutToLocation()->create();
  }
}
