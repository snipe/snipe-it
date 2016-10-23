<?php
use Illuminate\Database\Seeder;
use App\Models\Depreciation;

class DepreciationSeeder extends Seeder
{
  public function run()
  {
    Depreciation::truncate();
    factory(Depreciation::class, 'depreciation')->create();
  }
}
