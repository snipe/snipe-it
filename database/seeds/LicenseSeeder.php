<?php
use Illuminate\Database\Seeder;
use App\Models\License;
use App\Models\LicenseSeat;


class LicenseSeeder extends Seeder
{
  public function run()
  {
      License::truncate();
      factory(License::class, 'license', 10)->create();

      LicenseSeat::truncate();
      factory(LicenseSeat::class, 'license-seat', 10)->create();

      // factory(App\Models\Asset::class, 50)->create()->each(function($u) {
      //   $u->assetmodel()->save(factory(App\AssetModel::class)->make());
      // });
  }
}
