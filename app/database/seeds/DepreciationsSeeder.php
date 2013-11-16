<?php
class DepreciationsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$depreciation = array();

		$date = new DateTime;
		$depreciation[] = array(
			'name'      => 'Computers',
			'months'      => '36',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$date = new DateTime;
		$depreciation[] = array(
			'name'      => 'Software',
			'months'      => '36',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);


		$date = new DateTime;
		$depreciation[] = array(
			'name'      => 'Office Equipment',
			'months'      => '36',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		// Delete all the old data
		DB::table('depreciations')->truncate();

		// Insert the new data
		Depreciation::insert($depreciation);
	}

}


