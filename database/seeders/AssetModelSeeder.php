<?php

namespace Database\Seeders;

use App\Models\AssetModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AssetModelSeeder extends Seeder
{
    public function run()
    {
        AssetModel::truncate();

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        // Laptops
        AssetModel::factory()->count(1)->mbp13Model()->create(['user_id' => $admin->id]); // 1
        AssetModel::factory()->count(1)->mbpAirModel()->create(['user_id' => $admin->id]); // 2
        AssetModel::factory()->count(1)->surfaceModel()->create(['user_id' => $admin->id]); // 3
        AssetModel::factory()->count(1)->xps13Model()->create(['user_id' => $admin->id]); // 4
        AssetModel::factory()->count(1)->spectreModel()->create(['user_id' => $admin->id]); // 5
        AssetModel::factory()->count(1)->zenbookModel()->create(['user_id' => $admin->id]); // 6
        AssetModel::factory()->count(1)->yogaModel()->create(['user_id' => $admin->id]); // 7

        // Desktops
        AssetModel::factory()->count(1)->macproModel()->create(['user_id' => $admin->id]); // 8
        AssetModel::factory()->count(1)->lenovoI5Model()->create(['user_id' => $admin->id]); // 9
        AssetModel::factory()->count(1)->optiplexModel()->create(['user_id' => $admin->id]); // 10

        // Conference Phones
        AssetModel::factory()->count(1)->polycomModel()->create(['user_id' => $admin->id]); // 11
        AssetModel::factory()->count(1)->polycomcxModel()->create(['user_id' => $admin->id]); // 12

        // Tablets
        AssetModel::factory()->count(1)->ipadModel()->create(['user_id' => $admin->id]); // 13
        AssetModel::factory()->count(1)->tab3Model()->create(['user_id' => $admin->id]); // 14

        // Phones
        AssetModel::factory()->count(1)->iphone11Model()->create(['user_id' => $admin->id]); // 15
        AssetModel::factory()->count(1)->iphone12Model()->create(['user_id' => $admin->id]); // 16

        // Displays
        AssetModel::factory()->count(1)->ultrafine()->create(['user_id' => $admin->id]); // 17
        AssetModel::factory()->count(1)->ultrasharp()->create(['user_id' => $admin->id]); // 18

        $src = public_path('/img/demo/models/');
        $dst = 'models'.'/';
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
