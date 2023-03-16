<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Location;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        Asset::factory()
            ->count(1000)
            ->laptopMbp()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(50)
            ->laptopMbpPending()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(50)
            ->laptopMbpArchived()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(50)
            ->laptopAir()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(5)
            ->laptopSurface()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(5)
            ->laptopXps()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(5)
            ->laptopSpectre()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(5)
            ->laptopZenbook()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(3)
            ->laptopYoga()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(30)
            ->desktopMacpro()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(30)
            ->desktopLenovoI5()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(30)
            ->desktopOptiplex()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(5)
            ->confPolycom()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(2)
            ->confPolycomcx()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(12)
            ->tabletIpad()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(4)
            ->tabletTab3()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(27)
            ->phoneIphone11()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(40)
            ->phoneIphone12()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(10)
            ->ultrafine()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        Asset::factory()
            ->count(10)
            ->ultrasharp()
            ->state(new Sequence(fn($sequence) => [
                'rtd_location_id' => $locationIds->random(),
                'supplier_id' => $supplierIds->random(),
            ]))
            ->create();

        $del_files = Storage::files('assets');
        foreach ($del_files as $del_file) { // iterate files
            Log::debug('Deleting: ' . $del_files);
            try {
                Storage::disk('public')->delete('assets' . '/' . $del_files);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        DB::table('checkout_requests')->truncate();
    }
}
