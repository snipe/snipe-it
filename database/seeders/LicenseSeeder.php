<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        License::truncate();
        LicenseSeat::truncate();

        if (! Supplier::count()) {
            $this->call(SupplierSeeder::class);
        }

        $supplierIds = Supplier::all()->pluck('id');

        License::factory()->count(1)->photoshop()->create(['supplier_id' => $supplierIds->random()]);
        License::factory()->count(1)->acrobat()->create(['supplier_id' => $supplierIds->random()]);
        License::factory()->count(1)->indesign()->create(['supplier_id' => $supplierIds->random()]);
        License::factory()->count(1)->office()->create(['supplier_id' => $supplierIds->random()]);
    }
}
