<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        Maintenance::truncate();
        Maintenance::factory()->realistic()->create(['image' => '1.png']);
        Maintenance::factory()->realistic()->create(['image' => '2.png']);
        Maintenance::factory()->realistic()->create(['image' => '3.png']);
        Maintenance::factory()->realistic()->create(['image' => '4.png']);
        Maintenance::factory()->realistic()->create(['image' => '5.png']);
        Maintenance::factory()->realistic()->create(['image' => '6.png']);
        Maintenance::factory()->realistic()->create(['image' => '7.png']);
        Maintenance::factory()->realistic()->create(['image' => '8.png']);
        Maintenance::factory()->realistic()->create(['image' => '9.png']);
        Maintenance::factory()->realistic()->create(['image' => '10.png']);
        Maintenance::factory()->realistic()->create(['image' => '11.png']);

        $src = public_path('/img/demo/maintenances/');
        $dst = 'maintenances/';

        // See AssetSeeder for why this reads and deletes on the same
        // public disk using Storage::files()'s already-prefixed paths.
        $disk = Storage::disk('public');
        foreach ($disk->files(rtrim($dst, '/')) as $del_file) {
            Log::debug('Deleting: '.$del_file);
            try {
                $disk->delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        // Attached files on the private (default) disk. Same reset
        // rationale as the public dir above.
        foreach (Storage::files('private_uploads/maintenances') as $del_file) {
            Log::debug('Deleting: '.$del_file);
            try {
                Storage::delete($del_file);
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
