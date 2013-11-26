<?php
class LicensesSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$license = array();

		$date = new DateTime;

		// Pending (status_id is null, assigned_to = 0)
		$license[] = array(
			'name'      		=> 'Adobe Photoshop CS6',
			'serial'      		=> 'ZOMG-WtF-BBQ-SRSLY',
			'purchase_date' 	=> '2013-10-02',
			'purchase_cost' 	=> '2435.99',
			'order_number'  	=> '987698576946',
			'created_at' 		=> $date->modify('-10 day'),
			'updated_at' 		=> $date->modify('-3 day'),
			'seats' 			=> 5,
			'license_name'		=> '',
			'license_email'		=> '',
			'notes' 			=> '',
			'user_id'			=> 1,
			'depreciation_id'	=> 2,
			'deleted_at' 		=> NULL,
			'depreciate' 		=> '0',
		);

		// Pending (status_id is null, assigned_to = 0)
		$license[] = array(
			'name'      		=> 'Git Tower',
			'serial'      		=> '98049890394-340485934',
			'purchase_date' 	=> '2013-10-02',
			'purchase_cost' 	=> '2435.99',
			'order_number'  	=> '987698576946',
			'created_at' 		=> $date->modify('-10 day'),
			'updated_at' 		=> $date->modify('-3 day'),
			'seats' 			=> 2,
			'license_name'		=> 'Alison Gianotto',
			'license_email'		=> 'snipe@snipe.net',
			'notes' 			=> '',
			'user_id'			=> 1,
			'depreciation_id'	=> 2,
			'deleted_at' 		=> NULL,
			'depreciate' 		=> '0',
		);

		// Delete all the old data
		DB::table('licenses')->truncate();

		// Insert the new posts
		License::insert($license);
	}

}


