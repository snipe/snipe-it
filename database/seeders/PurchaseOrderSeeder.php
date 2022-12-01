<?php

namespace Database\Seeders;

use App\Models\ItemOrder;
use App\Models\PurchaseOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseOrder::truncate();
        DB::table('items_orders')->truncate();
        PurchaseOrder::factory()->has(ItemOrder::factory()->count(10))
        // ->addConsumable()
        ->create();
    }
}
