<?php
use Illuminate\Database\Seeder;
use App\Models\Manufacturer;

class ManufacturerSeeder extends Seeder
{
    public function run()
    {
        Manufacturer::truncate();
        factory(Manufacturer::class, 10)->create();
    }
}
