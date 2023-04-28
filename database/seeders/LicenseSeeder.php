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
        License::factory()->count(1)->photoshop()->create();
        License::factory()->count(1)->acrobat()->create();
        License::factory()->count(1)->indesign()->create();
        License::factory()->count(1)->office()->create();
    }
}
