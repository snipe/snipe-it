<?php
class LocationsSeeder extends Seeder
{
    public function run()
    {

        // Initialize empty array
        $location = array();

        $date = new DateTime;
        $location[] = array(
            'name'      		=> 'My Location',
            'address'     	 	=> '200 Main Street',
            'address2'                  => 'Suite 100',
            'city'      		=> 'New York',
            'state'      		=> 'NY',
            'country'      		=> 'US',
            'zip'      			=> '10004',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        $location[] = array(
            'name'      		=> 'Branch Office',
            'address'      		=> '1054 Pacific Ave',
            'address2'            	=> 'Unit 101-B',
            'city'     	 		=> 'San Fransico',
            'state'      		=> 'CA',
            'country'      		=> 'US',
            'zip'      			=> '92380',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        // Delete all the old data
        DB::table('locations')->truncate();

        // Insert the new posts
        Location::insert($location);
    }

}
