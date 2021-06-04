<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;

class AssetSeeder extends Seeder
{
  public function run()
  {
      Asset::truncate();
      Asset::factory()->count(1000)->assetLaptopMbp()->create();


      $del_files = Storage::files('assets');
      foreach($del_files as $del_file){ // iterate files
          \Log::debug('Deleting: '.$del_files);
          try  {
              Storage::disk('public')->delete('assets'.'/'.$del_files);
          } catch (\Exception $e) {
              \Log::debug($e);
          }
      }

      \DB::table('checkout_requests')->truncate();

  }
}
