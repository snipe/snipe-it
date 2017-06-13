<?php
use Illuminate\Database\Seeder;
use App\Models\Asset;


class AssetSeeder extends Seeder
{
  public function run()
  {
      Asset::truncate();
      factory(Asset::class, 100)->create();
  }
}
