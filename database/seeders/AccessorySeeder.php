<?php

namespace Database\Seeders;

use App\Models\Accessory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AccessorySeeder extends Seeder
{
    public function run()
    {
        Accessory::truncate();
        DB::table('accessories_users')->truncate();
        Accessory::factory()->count(1)->appleUsbKeyboard()->create();
        Accessory::factory()->count(1)->appleBtKeyboard()->create();
        Accessory::factory()->count(1)->appleMouse()->create();
        Accessory::factory()->count(1)->microsoftMouse()->create();

        $src = public_path('/img/demo/accessories/');
        $dst = 'accessories'.'/';
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
