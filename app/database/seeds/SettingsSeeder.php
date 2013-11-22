<?php
class SettingsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$setting = array();

		$date = new DateTime;
		$setting[] = array(
			'option_name'      	=> 'per_page',
			'option_label'      	=> 'Results Per Page',
			'option_value'     => '50',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
		);

		$setting[] = array(
			'option_name'      	=> 'site_name',
			'option_label'      	=> 'Site Name',
			'option_value'     => 'Snipe IT Asset Management System',
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


