<?php
class LicenseSeatsSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $license_seats = array();

        $date = new DateTime;

        // Pending (status_id is null, assigned_to = 0)
        $license_seats[] = array(
            'license_id'      	=> '1',
            'assigned_to'      	=> '1',
            'created_at' 		=> $date->modify('-10 day')->format('Y-m-d H:i:s'),
            'updated_at' 		=> $date->modify('-3 day')->format('Y-m-d H:i:s'),
            'deleted_at'  		=> NULL,
            'notes' 			=> '',
            'user_id' 			=> '1',
            'asset_id' 			=> '1',
        );

        $license_seats[] = array(
            'license_id'      	=> '1',
            'assigned_to'      	=> '2',
            'created_at' 		=> $date->modify('-10 day')->format('Y-m-d H:i:s'),
            'updated_at' 		=> $date->modify('-3 day')->format('Y-m-d H:i:s'),
            'deleted_at' 		=> NULL,
            'notes' 			=> '',
            'user_id' 			=> '1',
            'asset_id' 			=> '2',
        );

        $license_seats[] = array(
            'license_id'      	=> '1',
            'assigned_to'      	=> '2',
            'created_at' 		=> $date->modify('-10 day')->format('Y-m-d H:i:s'),
            'updated_at' 		=> $date->modify('-3 day')->format('Y-m-d H:i:s'),
            'deleted_at' 		=> NULL,
            'notes' 			=> '',
            'user_id' 			=> '1',
            'asset_id' 			=> '3',
        );

        $license_seats[] = array(
            'license_id'      	=> '1',
            'assigned_to'      	=> '0',
            'created_at' 		=> $date->modify('-10 day')->format('Y-m-d H:i:s'),
            'updated_at' 		=> $date->modify('-3 day')->format('Y-m-d H:i:s'),
            'deleted_at' 		=> NULL,
            'notes' 			=> '',
            'user_id' 			=> '1',
            'asset_id' 			=> NULL,
        );

        $license_seats[] = array(
            'license_id'      	=> '1',
            'assigned_to'      	=> '2',
            'created_at' 		=> $date->modify('-10 day')->format('Y-m-d H:i:s'),
            'updated_at' 		=> $date->modify('-3 day')->format('Y-m-d H:i:s'),
            'deleted_at' 		=> NULL,
            'notes' 			=> '',
            'user_id' 			=> '1',
            'asset_id' 			=> NULL,
        );

        $license_seats[] = array(
            'license_id'      	=> '2',
            'assigned_to'      	=> '1',
            'created_at' 		=> $date->modify('-10 day')->format('Y-m-d H:i:s'),
            'updated_at' 		=> $date->modify('-3 day')->format('Y-m-d H:i:s'),
            'deleted_at' 		=> NULL,
            'notes' 			=> '',
            'user_id' 			=> '1',
            'asset_id' 			=> NULL,
        );

        // Pending (status_id is null, assigned_to = 0)
        $license_seats[] = array(
            'license_id'      	=> '2',
            'assigned_to'      	=> '0',
            'created_at' 		=> $date->modify('-10 day')->format('Y-m-d H:i:s'),
            'updated_at' 		=> $date->modify('-3 day')->format('Y-m-d H:i:s'),
            'deleted_at' 		=> NULL,
            'notes' 			=> '',
            'user_id' 			=> '1',
            'asset_id' 			=> NULL,

        );

        // Delete all the old data
        DB::table('license_seats')->truncate();

        // Insert the new posts
        LicenseSeat::insert($license_seats);
    }

}
