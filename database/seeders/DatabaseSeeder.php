<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Only create default settings if they do not exist in the db.
        if (! Setting::first()) {
            $this->call(SettingsSeeder::class);
        }

        /**
         * The order of these MATTER because we introspect into the database
         * for some of the validation on these models.
         */
        $this->call([
            SupplierSeeder::class,
            DepreciationSeeder::class,
            ManufacturerSeeder::class,
            LocationSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            StatuslabelSeeder::class,
            CategorySeeder::class,
            AssetModelSeeder::class,
            AssetSeeder::class,
            ActionlogSeeder::class,

        ]);

        //$this->call(DepreciationSeeder::class);
        //$this->call(AssetModelSeeder::class);
        //$this->call(DepreciationSeeder::class);
        //$this->call(AccessorySeeder::class);
        //$this->call(AssetSeeder::class);
        //$this->call(LicenseSeeder::class);
        //$this->call(ComponentSeeder::class);
        //$this->call(ConsumableSeeder::class);
        //$this->call(ActionlogSeeder::class);
        //$this->call(CustomFieldSeeder::class);

        // \Artisan::call('snipeit:sync-asset-locations', ['--output' => 'all']);
        //$output = \Artisan::output();
        // \Log::info($output);

        Model::reguard();

        \DB::table('imports')->truncate();
        \DB::table('asset_maintenances')->truncate();
        \DB::table('requested_assets')->truncate();
    }
}
