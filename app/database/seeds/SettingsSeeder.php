<?php
class SettingsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$setting = array();

		$date = new DateTime;
		$setting[] = array(
			'per_page'      	=> '50',
			'site_name'      	=> 'Snipe IT Asset Management',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
		);


		// Delete all the old data
		DB::table('settings')->truncate();

		// Insert the new posts
		Setting::insert($setting);
	}

}


