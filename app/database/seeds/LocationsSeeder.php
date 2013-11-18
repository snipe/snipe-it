<?php
class LocationsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$location = array();

		$date = new DateTime;
		$location[] = array(
			'name'      => 'NY - Broad St',
			'address'		=> '23 Broad St',
			'address2'	=> '',
			'city'      => 'New York',
			'state'      => 'NY',
			'zip'				=> '10010',
			'country'      => 'US',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$location[] = array(
			'name'      => 'NY - Water St',
			'address'		=> '110 Water St',
			'address2'	=> '',
			'city'      => 'New York',
			'state'      => 'NY',
			'zip'				=> '10013',
			'country'      => 'US',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$location[] = array(
			'name'      => 'SF - Broadway',
			'address'		=> '22 Broadway Ave',
			'address2'	=> '',
			'city'      => 'San Francisco',
			'state'      => 'CA',
			'zip'				=> '90013',
			'country'      => 'US',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$location[] = array(
			'name'      => 'LA - Hollywood Blvd',
			'address'		=> '1929 Hollywood Blvd',
			'address2'	=> '',
			'city'      => 'Los Angeles',
			'state'      => 'CA',
			'zip'				=> '91113',
			'country'      => 'US',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);







		// Delete all the old data
		DB::table('locations')->truncate();

		// Insert the new posts
		Location::insert($location);
	}

}


