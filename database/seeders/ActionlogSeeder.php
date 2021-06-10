<?php

namespace Database\Seeders;

use App\Models\Actionlog;
use Illuminate\Database\Seeder;

class ActionlogSeeder extends Seeder
{
    public function run()
    {
        Actionlog::truncate();
        Actionlog::factory()->count('asset-checkout-user', 300)->create();
        Actionlog::factory()->count('asset-checkout-location', 100)->create();
    }
}
