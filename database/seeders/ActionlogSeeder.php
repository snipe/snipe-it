<?php

namespace Database\Seeders;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Location;
use Illuminate\Database\Seeder;

class ActionlogSeeder extends Seeder
{
    public function run()
    {
        Actionlog::truncate();

        if (! Asset::count()) {
            $this->call(AssetSeeder::class);
        }

        if (! Location::count()) {
            $this->call(LocationSeeder::class);
        }

        Actionlog::factory()
            ->count(300)
            ->assetCheckoutToUser()
            ->create();

        Actionlog::factory()
            ->count(100)
            ->assetCheckoutToLocation()
            ->create();
    }
}
