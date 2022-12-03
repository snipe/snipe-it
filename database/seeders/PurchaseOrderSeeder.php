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
        for ($i = 0; $i < 500; $i++) {
            PurchaseOrder::factory()->has(ItemOrder::factory()->count(3)->consumables())
                ->has(ItemOrder::factory()->count(1)->components())
                ->has(ItemOrder::factory()->count(1)->accesorys())
                ->create();
        }
    }
}
