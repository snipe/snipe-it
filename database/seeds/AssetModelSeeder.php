<?php

use Illuminate\Database\Seeder;
use App\Models\AssetModel;

class AssetModelSeeder extends Seeder
{
    public function run()
    {
        AssetModel::truncate();

        // Laptops
        factory(AssetModel::class, 1)->states('mbp-13-model')->create();
        factory(AssetModel::class, 1)->states('mbp-air-model')->create();
        factory(AssetModel::class, 1)->states('surface-model')->create();
        factory(AssetModel::class, 1)->states('xps13-model')->create();
        factory(AssetModel::class, 1)->states('spectre-model')->create();
        factory(AssetModel::class, 1)->states('zenbook-model')->create();
        factory(AssetModel::class, 1)->states('yoga-model')->create();

        // Desktops
        factory(AssetModel::class, 1)->states('macpro-model')->create();
        factory(AssetModel::class, 1)->states('lenovo-i5-model')->create();
        factory(AssetModel::class, 1)->states('optiplex-model')->create();

        // Conference Phones
        factory(AssetModel::class, 1)->states('polycom-model')->create();
        factory(AssetModel::class, 1)->states('polycomcx-model')->create();

        // Tablets
        factory(AssetModel::class, 1)->states('ipad-model')->create();
        factory(AssetModel::class, 1)->states('tab3-model')->create();

        // Phones
        factory(AssetModel::class, 1)->states('iphone6s-model')->create();
        factory(AssetModel::class, 1)->states('iphone7-model')->create();


    }

}
