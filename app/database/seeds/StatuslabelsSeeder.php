<?php
class StatuslabelsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$status = array();

		$date = new DateTime;

		$status[] = array(
			'name'      => 'Out for Diagnostics',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'deleted_at' 		=> NULL,
		);


		$status[] = array(
			'name'      => 'Out for Repair',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'deleted_at' 		=> NULL,
		);


		$status[] = array(
			'name'      => 'Broken - Not Fixable',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'deleted_at' 		=> NULL,
		);

		$status[] = array(
			'name'      => 'Lost/Stolen',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'deleted_at' 		=> NULL,
		);



		// Delete all the old data
		DB::table('status_labels')->truncate();

		// Insert the new posts
		Statuslabel::insert($status);
	}

}


