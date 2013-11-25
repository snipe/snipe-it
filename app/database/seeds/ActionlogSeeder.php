<?php
class ActionlogSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$assetlog = array();

		$date = new DateTime;

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      	=> '1',
			'action_type'      	=> 'checkout',
			'asset_id' => '1',
			'checkedout_to' => '3',
			'location_id'  => '3',
			'added_on' 	=> $date->modify('-10 day'),
			'asset_type' 	=> 'hardware',
		);

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      	=> '1',
			'action_type'      	=> 'checkin from',
			'asset_id' => '1',
			'checkedout_to' => '3',
			'location_id'  => NULL,
			'added_on' 	=> $date->modify('-10 day'),
			'asset_type' 	=> 'hardware',
		);

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      	=> '1',
			'action_type'      	=> 'checkout',
			'asset_id' => '1',
			'checkedout_to' => '3',
			'location_id'  => '3',
			'added_on' 	=> $date->modify('-10 day'),
			'asset_type' 	=> 'software',
		);

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      	=> '1',
			'action_type'      	=> 'checkin from',
			'asset_id' => '1',
			'checkedout_to' => '3',
			'location_id'  => NULL,
			'added_on' 	=> $date->modify('-10 day'),
			'asset_type' 	=> 'software',
		);


		// Delete all the old data
		DB::table('asset_logs')->truncate();

		// Insert the new posts
		Actionlog::insert($assetlog);
	}

}


