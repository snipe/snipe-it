<?php
use Illuminate\Database\Seeder;
use App\Models\License;
use App\Models\LicenseSeat;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        License::truncate();
        factory(License::class, 10)->create();

        LicenseSeat::truncate();
        factory(LicenseSeat::class, 10)->create();
    }
}
