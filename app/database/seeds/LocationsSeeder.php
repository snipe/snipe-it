<?php
class LocationsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$location = array();

		$date = new DateTime;
		$location[] = array(
			'name'      		=> 'NY - Broad St',
			'address'     	 	=> '200 Broad Street',
			'address2'      	=> 'Suite 142',
			'city'      		=> 'New York',
			'state'      		=> 'NY',
			'country'      		=> 'US',
			'zip'      			=> '10004',
			'created_at' 		=> $date->modify('-10 day'),
			'updated_at' 		=> $date->modify('-3 day'),
			'user_id' 			=> 1,
			'deleted_at' 		=> NULL,
		);

		$location[] = array(
			'name'      		=> 'NY - Water St',
			'address'      		=> '200 Broad Street',
			'address2'      	=> 'Suite 142',
			'city'     	 		=> 'New York',
			'state'      		=> 'NY',
			'country'      		=> 'US',
			'zip'      			=> '10004',
			'created_at' 		=> $date->modify('-10 day'),
			'updated_at' 		=> $date->modify('-3 day'),
			'user_id' 			=> 1,
			'deleted_at' 		=> NULL,
		);

		$location[] = array(
			'name'      		=> 'SF - Broadway',
			'address'      		=> '200 Broadway',
			'address2'      	=> 'Suite 142',
			'city'      		=> 'San Francisco',
			'state'      		=> 'CA',
			'country'      		=> 'US',
			'zip'      			=> '94111',
			'created_at' 		=> $date->modify('-10 day'),
			'updated_at' 		=> $date->modify('-3 day'),
			'user_id' 			=> 1,
			'deleted_at' 		=> NULL,
		);

		$location[] = array(
			'name'      		=> 'LA - Hollywood Blvd',
			'address'      		=> '6253 Hollywood Blvd',
			'address2'      	=> 'Suite 142',
			'city'      		=> 'Los Angeles',
			'state'      		=> 'CA',
			'country'      		=> 'US',
			'zip'      			=> '90028',
			'created_at' 		=> $date->modify('-10 day'),
			'updated_at' 		=> $date->modify('-3 day'),
			'user_id' 			=> 1,
			'deleted_at' 		=> NULL,
		);


		// Delete all the old data
		DB::table('locations')->truncate();

		// Insert the new posts
		Location::insert($location);
	}

}


