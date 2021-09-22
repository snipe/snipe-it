<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManufacturerSeeder extends Seeder
{
    public function run()
    {
        Manufacturer::truncate();
        Manufacturer::factory()->count(1)->apple()->create(); // 1
        Manufacturer::factory()->count(1)->microsoft()->create(); // 2
        Manufacturer::factory()->count(1)->dell()->create(); // 3
        Manufacturer::factory()->count(1)->asus()->create(); // 4
        Manufacturer::factory()->count(1)->hp()->create(); // 5
        Manufacturer::factory()->count(1)->lenovo()->create(); // 6
        Manufacturer::factory()->count(1)->lg()->create(); // 7
        Manufacturer::factory()->count(1)->polycom()->create(); // 8
        Manufacturer::factory()->count(1)->adobe()->create(); // 9
        Manufacturer::factory()->count(1)->avery()->create(); // 10
        Manufacturer::factory()->count(1)->crucial()->create(); // 10

        $src = public_path('/img/demo/manufacturers/');
        $dst = 'manufacturers'.'/';
        $del_files = Storage::files($dst);

        foreach ($del_files as $del_file) { // iterate files
            $file_to_delete = str_replace($src, '', $del_file);
            Log::debug('Deleting: '.$file_to_delete);
            try {
                Storage::disk('public')->delete($dst.$del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        $add_files = glob($src.'/*.*');
        foreach ($add_files as $add_file) {
            $file_to_copy = str_replace($src, '', $add_file);
            Log::debug('Copying: '.$file_to_copy);
            try {
                Storage::disk('public')->put($dst.$file_to_copy, file_get_contents($src.$file_to_copy));
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }
    }
}
