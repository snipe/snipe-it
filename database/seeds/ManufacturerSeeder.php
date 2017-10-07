<?php
use Illuminate\Database\Seeder;
use App\Models\Manufacturer;

class ManufacturerSeeder extends Seeder
{
    public function run()
    {
        Manufacturer::truncate();
        factory(Manufacturer::class, 1)->states('apple')->create(); // 1
        factory(Manufacturer::class, 1)->states('microsoft')->create(); // 2
        factory(Manufacturer::class, 1)->states('dell')->create(); // 3
        factory(Manufacturer::class, 1)->states('asus')->create(); // 4
        factory(Manufacturer::class, 1)->states('hp')->create(); // 5
        factory(Manufacturer::class, 1)->states('lenovo')->create(); // 6
        factory(Manufacturer::class, 1)->states('lg')->create(); // 7
        factory(Manufacturer::class, 1)->states('polycom')->create(); // 8
        factory(Manufacturer::class, 1)->states('adobe')->create(); // 9
        factory(Manufacturer::class, 1)->states('avery')->create(); // 10
        
    }
}
