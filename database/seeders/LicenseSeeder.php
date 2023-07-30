<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        License::truncate();
        LicenseSeat::truncate();

        if (! Category::count()) {
            $this->call(CategorySeeder::class);
        }

        $categoryIds = Category::all()->pluck('id');

        if (! Supplier::count()) {
            $this->call(SupplierSeeder::class);
        }

        $supplierIds = Supplier::all()->pluck('id');

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        License::factory()->count(1)->photoshop()->create([
            'category_id' => $categoryIds->random(),
            'supplier_id' => $supplierIds->random(),
            'user_id' => $admin->id,
        ]);

        License::factory()->count(1)->acrobat()->create([
            'category_id' => $categoryIds->random(),
            'supplier_id' => $supplierIds->random(),
            'user_id' => $admin->id,
        ]);

        License::factory()->count(1)->indesign()->create([
            'category_id' => $categoryIds->random(),
            'supplier_id' => $supplierIds->random(),
            'user_id' => $admin->id,
        ]);

        License::factory()->count(1)->office()->create([
            'category_id' => $categoryIds->random(),
            'supplier_id' => $supplierIds->random(),
            'user_id' => $admin->id,
        ]);
    }
}
