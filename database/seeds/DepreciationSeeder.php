<?php
use Illuminate\Database\Seeder;
use App\Models\Depreciation;

class DepreciationSeeder extends Seeder
{
    public function run()
    {
        Depreciation::truncate();
        factory(Depreciation::class, 1)->states('computer')->create(); // 1
        factory(Depreciation::class, 1)->states('display')->create(); // 2
        factory(Depreciation::class, 1)->states('mobile-phones')->create(); // 3
    }
}
