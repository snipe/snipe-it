<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::truncate();
        Supplier::factory()->count(6)->create();

    }
}
