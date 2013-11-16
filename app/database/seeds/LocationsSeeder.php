<?php
class LocationsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$location = array();

		$date = new DateTime;
		$location[] = array(
			'name'      => 'NY - Broad St',
			'city'      => 'New York',
			'state'      => 'NY',
			'country'      => 'US',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$location[] = array(
			'name'      => 'NY - Water St',
			'city'      => 'New York',
			'state'      => 'NY',
			'country'      => 'US',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$location[] = array(
			'name'      => 'SF - Broadway',
			'city'      => 'San Francisco',
			'state'      => 'CA',
			'country'      => 'US',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$location[] = array(
			'name'      => 'LA - Hollywood Blvd',
			'city'      => 'Los Angeles',
			'state'      => 'CA',
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


