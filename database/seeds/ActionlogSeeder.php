<?php

use App\Models\Actionlog;
use Illuminate\Database\Seeder;

class ActionlogSeeder extends Seeder
{
    public function run()
    {
        Actionlog::truncate();
        factory(Actionlog::class, 'asset-checkout-user', 300)->create();
        factory(Actionlog::class, 'asset-checkout-location', 100)->create();
    }
}
