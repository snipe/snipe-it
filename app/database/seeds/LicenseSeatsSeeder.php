<?php
class LicenseSeatsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$license_seats = array();

		$date = new DateTime;

		// Pending (status_id is null, assigned_to = 0)
		$license_seats[] = array(
			'license_id'      	=> '1',
			'assigned_to'      	=> '1',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
		);

		$license_seats[] = array(
			'license_id'      	=> '1',
			'assigned_to'      	=> NULL,
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
		);

		$license_seats[] = array(
			'license_id'      	=> '1',
			'assigned_to'      	=> NULL,
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
		);

		$license_seats[] = array(
			'license_id'      	=> '1',
			'assigned_to'      	=> NULL,
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
		);

		$license_seats[] = array(
			'license_id'      	=> '1',
			'assigned_to'      	=> '2',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
		);

		$license_seats[] = array(
			'license_id'      	=> '2',
			'assigned_to'      	=> '1',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
		);

		// Pending (status_id is null, assigned_to = 0)
		$license_seats[] = array(
			'license_id'      	=> '2',
			'assigned_to'      	=> NULL,
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),

		);

		// Delete all the old data
		DB::table('license_seats')->truncate();

		// Insert the new posts
		LicenseSeat::insert($license_seats);
	}

}


