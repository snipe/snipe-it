<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\LicenseSeat;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        License::truncate();
        LicenseSeat::truncate();
        factory(License::class, 1)->states('photoshop')->create();
        factory(License::class, 1)->states('acrobat')->create();
        factory(License::class, 1)->states('indesign')->create();
        factory(License::class, 1)->states('office')->create();
    }
}
