<?php
class AssetMaintenancesSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $asset_maintenances = array();

        $date = new DateTime;


        $asset_maintenances[] = array(
            'asset_id'      	=> 1,
            'supplier_id'      => 1,
            'asset_maintenance_type' => 'Maintenance',
            'title'      	=> 'Test Maintenance',
            'start_date' 	=> $date->modify('-10 day'),
            'cost'  => '200.99',
            'is_warranty'  => '0',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
        );



        // Delete all the old data
        DB::table('asset_maintenances')->truncate();

        // Insert the new posts
        AssetMaintenance::insert($asset_maintenances);
    }

}
