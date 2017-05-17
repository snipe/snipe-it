<?php

use Illuminate\Database\Seeder;
use App\Models\AssetModel;

class AssetModelSeeder extends Seeder
{
    public function run()
    {
        AssetModel::truncate();
        factory(AssetModel::class,5)->create();
    }

}
