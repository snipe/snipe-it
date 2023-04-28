<?php

namespace Database\Seeders;

use App\Models\Actionlog;
use Illuminate\Database\Seeder;

class ActionlogSeeder extends Seeder
{
    public function run()
    {
        Actionlog::truncate();
        Actionlog::factory()->count(300)->assetCheckoutToUser()->create();
        Actionlog::factory()->count(100)->assetCheckoutToLocation()->create();

        
    }
}
