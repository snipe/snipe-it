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
        factory(Manufacturer::class, 1)->states('crucial')->create(); // 10

        $src = public_path('/img/demo/manufacturers');
        $dst =  public_path('/uploads/manufacturers');

        $del_files = glob($dst."/*.*");

        foreach($del_files as $del_file){ // iterate files
            if(is_file($del_file))
                unlink($del_file); // delete file
        }


        $add_files = glob($src."/*.*");
        foreach($add_files as $add_file){
            $file_to_copy = str_replace($src,$dst,$add_file);
            copy($add_file, $file_to_copy);
        }

        
    }


}
