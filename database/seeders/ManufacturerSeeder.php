<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ManufacturerSeeder extends Seeder
{
    public function run()
    {
        Manufacturer::truncate();
        Manufacturer::factory()->count(1)->mfgApple()->create();
        Manufacturer::factory()->count(1)->mfgMicrosoft()->create();
        Manufacturer::factory()->count(1)->mfgDell()->create();
        Manufacturer::factory()->count(1)->mfgAsus()->create();
        Manufacturer::factory()->count(1)->mfgHp()->create();
        Manufacturer::factory()->count(1)->mfgLenovo()->create();
        Manufacturer::factory()->count(1)->mfgLg()->create();
        Manufacturer::factory()->count(1)->mfgPolycom()->create();
        Manufacturer::factory()->count(1)->mfgAdobe()->create();
        Manufacturer::factory()->count(1)->mfgAvery()->create();
        Manufacturer::factory()->count(1)->mfgCrucial()->create();

        $src = public_path('/img/demo/manufacturers/');
        $dst = 'manufacturers'.'/';
        $del_files = Storage::files($dst);

        foreach ($del_files as $del_file) { // iterate files
            $file_to_delete = str_replace($src, '', $del_file);
            // \Log::debug('Deleting: '.$file_to_delete);
            try {
                Storage::disk('public')->delete($dst.$del_file);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }

        $add_files = glob($src.'/*.*');
        foreach ($add_files as $add_file) {
            $file_to_copy = str_replace($src, '', $add_file);
            \Log::debug('Copying: '.$file_to_copy);
            try {
                Storage::disk('public')->put($dst.$file_to_copy, file_get_contents($src.$file_to_copy));
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }
    }
}
