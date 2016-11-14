<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

<<<<<<< HEAD
        $this->call(AssetModelSeeder::class);
        $this->call(AccessorySeeder::class);
        $this->call(AssetSeeder::class);
=======
        $this->call(CompanySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AssetModelSeeder::class);
        $this->call(AccessorySeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(ComponentSeeder::class);
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
        $this->call(ConsumableSeeder::class);
        $this->call(StatuslabelSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LicenseSeeder::class);
        $this->call(ActionlogSeeder::class);
        $this->call(DepreciationSeeder::class);
        $this->call(ManufacturerSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(CustomFieldSeeder::class);
<<<<<<< HEAD
        $this->call(ComponentSeeder::class);
=======
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

        Model::reguard();
    }
}
