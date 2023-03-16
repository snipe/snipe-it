<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Location;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AssetSeeder extends Seeder
{
    public function run()
    {
        Asset::truncate();

        if (! Location::count()) {
            $this->call(LocationSeeder::class);
        }

        $locationIds = Location::all()->pluck('id');

        if (! Supplier::count()) {
            $this->call(SupplierSeeder::class);
        }

        $supplierIds = Supplier::all()->pluck('id');

        Asset::factory()->count(1000)->laptopMbp()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(50)->laptopMbpPending()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(50)->laptopMbpArchived()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(50)->laptopAir()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(5)->laptopSurface()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(5)->laptopXps()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(5)->laptopSpectre()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(5)->laptopZenbook()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(3)->laptopYoga()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);

        Asset::factory()->count(30)->desktopMacpro()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(30)->desktopLenovoI5()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(30)->desktopOptiplex()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);

        Asset::factory()->count(5)->confPolycom()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(2)->confPolycomcx()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);

        Asset::factory()->count(12)->tabletIpad()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(4)->tabletTab3()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);

        Asset::factory()->count(27)->phoneIphone11()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(40)->phoneIphone12()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);

        Asset::factory()->count(10)->ultrafine()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);
        Asset::factory()->count(10)->ultrasharp()->create([
            'rtd_location_id' => $locationIds->random(),
            'supplier_id' => $supplierIds->random(),
        ]);

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
