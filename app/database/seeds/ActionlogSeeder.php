<?php
class ActionlogSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$assetlog = array();

		$date = new DateTime;

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      		=> '1',
			'action_type'      	=> 'checkout',
			'asset_id' 			=> '1',
			'checkedout_to' 	=> '2',
			'location_id'  		=> '3',
			'added_on' 			=> $date->modify('-10 day'),
			'asset_type' 		=> 'hardware',
			'note'				=> NULL,
			'filename'			=> NULL,
		);

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      		=> '1',
			'action_type'      	=> 'checkin from',
			'asset_id' 			=> '1',
			'checkedout_to' 	=> '2',
			'location_id'  		=> NULL,
			'added_on' 			=> $date->modify('-10 day'),
			'asset_type' 		=> 'hardware',
			'note'				=> NULL,
			'filename'			=> NULL,
		);

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      		=> '1',
			'action_type'      	=> 'checkout',
			'asset_id' 			=> '1',
			'checkedout_to' 	=> '1',
			'location_id'  		=> '3',
			'added_on' 			=> $date->modify('-10 day'),
			'asset_type' 		=> 'software',
			'note'				=> NULL,
			'filename'			=> NULL,
		);

		// Pending (status_id is null, assigned_to = 0)
		$assetlog[] = array(
			'user_id'      		=> '1',
			'action_type'      	=> 'checkin from',
			'asset_id' 			=> '1',
			'checkedout_to' 	=> '2',
			'location_id'  		=> NULL,
			'added_on' 			=> $date->modify('-10 day'),
			'asset_type' 		=> 'software',
			'note'				=> NULL,
			'filename'			=> NULL,
		);


		// Delete all the old data
		DB::table('asset_logs')->truncate();

		// Insert the new posts
		Actionlog::insert($assetlog);
	}

}


