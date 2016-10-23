<?php
use Illuminate\Database\Seeder;
use App\Models\Asset;


class AssetSeeder extends Seeder
{
  public function run()
  {
      Asset::truncate();
      factory(Asset::class, 'asset', 100)->create();

      // factory(App\Models\Asset::class, 50)->create()->each(function($u) {
      //   $u->assetmodel()->save(factory(App\AssetModel::class)->make());
      // });
  }
}
