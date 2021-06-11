<?php

namespace Database\Seeders;

use App\Models\AssetModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AssetModelSeeder extends Seeder
{
    public function run()
    {
        AssetModel::truncate();

        // Laptops
        AssetModel::factory()->count(1)->assetModelMbp13()->create();
        AssetModel::factory()->count(1)->assetModelAir()->create();
        AssetModel::factory()->count(1)->assetModelSurface()->create();
        AssetModel::factory()->count(1)->assetModelXps13()->create();
        AssetModel::factory()->count(1)->assetModelSpectre()->create();
        AssetModel::factory()->count(1)->assetModelZenbook()->create();
        AssetModel::factory()->count(1)->assetModelYoga()->create();

        // Desktops
        AssetModel::factory()->count(1)->assetModelMacPro()->create();
        AssetModel::factory()->count(1)->assetModelLenovoi5()->create();
        AssetModel::factory()->count(1)->assetModelOptiplex()->create();

        // Conference Phones
        AssetModel::factory()->count(1)->assetModelPolycom()->create();
        AssetModel::factory()->count(1)->assetModelPolycomCx()->create();

        // Tablets
        AssetModel::factory()->count(1)->assetModelIpad()->create();
        AssetModel::factory()->count(1)->assetModelTab3()->create();

        // Phones
        AssetModel::factory()->count(1)->assetModelIphone6()->create();
        AssetModel::factory()->count(1)->assetModelIphone7()->create();

        // Displays
        AssetModel::factory()->count(1)->assetModelUltrafine()->create();
        AssetModel::factory()->count(1)->assetModelUltrasharp()->create();

        $src = public_path('/img/demo/models/');
        $dst = 'models'.'/';
        $del_files = Storage::files($dst);

        foreach ($del_files as $del_file) { // iterate files
            $file_to_delete = str_replace($src, '', $del_file);
            \Log::debug('Deleting: '.$file_to_delete);
            try {
                Storage::disk('public')->delete($dst.$del_file);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }

        $add_files = glob($src.'/*.*');
        foreach ($add_files as $add_file) {
            $file_to_copy = str_replace($src, '', $add_file);
            // \Log::debug('Copying: '.$file_to_copy);
            try {
                Storage::disk('public')->put($dst.$file_to_copy, file_get_contents($src.$file_to_copy));
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }
    }
}
