<?php

use App\Models\LicenseModel;
use Illuminate\Database\Seeder;
use App\Models\License;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        LicenseModel::truncate();
        License::truncate();
        factory(LicenseModel::class, 1)->states('photoshop')->create();
        factory(LicenseModel::class, 1)->states('acrobat')->create();
        factory(LicenseModel::class, 1)->states('indesign')->create();
        factory(LicenseModel::class, 1)->states('office')->create();
    }
}
