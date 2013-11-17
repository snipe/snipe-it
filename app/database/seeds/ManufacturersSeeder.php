<?php

class ManufacturersSeeder extends Seeder {

	public function run()
	{

		$date = date("Y-m-d");
		$manufacturers[] = array(
			'name'      => 'Apple',
			'created_at' => $date,
			'user_id' => 1,
		);
		$manufacturers[] = array(
			'name'      => 'Microsoft',
			'created_at' => $date,
			'user_id' => 1,
		);
		$manufacturers[] = array(
			'name'      => 'ASUS',
			'created_at' => $date,
			'user_id' => 1,
		);
		$manufacturers[] = array(
			'name'      => 'Dell',
			'created_at' => $date,
			'user_id' => 1,
		);

		$manufacturers[] = array(
			'name'      => 'Tower Software',
			'created_at' => $date,
			'user_id' => 1,
		);

		$manufacturers[] = array(
			'name'      => 'Adobe',
			'created_at' => $date,
			'user_id' => 1,
		);


		// Delete all the blog posts
		DB::table('manufacturers')->truncate();

		// Insert the blog posts
		Manufacturer::insert($manufacturers);
	}

}
