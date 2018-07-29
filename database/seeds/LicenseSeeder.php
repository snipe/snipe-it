<?php
use Illuminate\Database\Seeder;
use App\Models\LicenseModel;
use App\Models\LicenseSeat;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        LicenseModel::truncate();
        LicenseSeat::truncate();
        factory(LicenseModel::class, 1)->states('photoshop')->create();
        factory(LicenseModel::class, 1)->states('acrobat')->create();
        factory(LicenseModel::class, 1)->states('indesign')->create();
        factory(LicenseModel::class, 1)->states('office')->create();
    }
}
