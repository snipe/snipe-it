<?php
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::truncate();
        factory(Supplier::class, 5)->create();

    }
}
