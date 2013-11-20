<?php
class LocationsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$status = array();

		$date = new DateTime;
		$status[] = array(
			'name'      => 'Ready to Deploy',
			'deployable' => '1',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$status[] = array(
			'name'      => 'Out for Diagnostics',
			'deployable' => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);


		$status[] = array(
			'name'      => 'Out for Repair',
			'deployable' => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);


		$status[] = array(
			'name'      => 'Broken - Not Fixable',
			'deployable' => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);







		// Delete all the old data
		DB::table('status')->truncate();

		// Insert the new posts
		Location::insert($status);
	}

}


