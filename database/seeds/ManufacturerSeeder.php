<?php
use Illuminate\Database\Seeder;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Storage;

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

        $src = public_path('/img/demo/manufacturers/');
        $dst = 'manufacturers'.'/';
        $del_files = Storage::files($dst);

        foreach($del_files as $del_file){ // iterate files
            $file_to_delete = str_replace($src,'',$del_file);
            \Log::debug('Deleting: '.$file_to_delete);
            try  {
                Storage::disk('public')->delete($dst.$del_file);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }


        $add_files = glob($src."/*.*");
        foreach($add_files as $add_file){
            $file_to_copy = str_replace($src,'',$add_file);
            \Log::debug('Copying: '.$file_to_copy);
            try  {
                Storage::disk('public')->put($dst.$file_to_copy, file_get_contents($src.$file_to_copy));
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }

        
    }


}
