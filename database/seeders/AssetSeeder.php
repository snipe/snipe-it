<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AssetSeeder extends Seeder
{
    public function run()
    {
        Asset::truncate();
        Asset::factory()->count(1000)->laptopMbp()->create();
        Asset::factory()->count(50)->laptopMbpPending()->create();
        Asset::factory()->count(50)->laptopMbpArchived()->create();
        Asset::factory()->count(50)->laptopAir()->create();
        Asset::factory()->count(5)->laptopSurface()->create();
        Asset::factory()->count(5)->laptopXps()->create();
        Asset::factory()->count(5)->laptopSpectre()->create();
        Asset::factory()->count(5)->laptopZenbook()->create();
        Asset::factory()->count(3)->laptopYoga()->create();

        Asset::factory()->count(30)->desktopMacpro()->create();
        Asset::factory()->count(30)->desktopLenovoI5()->create();
        Asset::factory()->count(30)->desktopOptiplex()->create();

        Asset::factory()->count(5)->confPolycom()->create();
        Asset::factory()->count(2)->confPolycomcx()->create();

        Asset::factory()->count(12)->tabletIpad()->create();
        Asset::factory()->count(4)->tabletTab3()->create();

        Asset::factory()->count(27)->phoneIphone11()->create();
        Asset::factory()->count(40)->phoneIphone12()->create();

        Asset::factory()->count(10)->ultrafine()->create();
        Asset::factory()->count(10)->ultrasharp()->create();

        $del_files = Storage::files('assets');
        foreach ($del_files as $del_file) { // iterate files
            Log::debug('Deleting: '.$del_files);
            try {
                Storage::disk('public')->delete('assets'.'/'.$del_files);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        DB::table('checkout_requests')->truncate();
    }
}
