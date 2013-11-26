<?php

class ManufacturersSeeder extends Seeder {

	public function run()
	{

		$date = date("Y-m-d");
		$manufacturers[] = array(
			'name'     		 	=> 'Apple',
			'created_at' 		=> $date,
			'user_id' 			=> 1,
			'updated_at' 		=> $date,
			'deleted_at' 		=> NULL,
		);

		$manufacturers[] = array(
			'name'     		 	=> 'Microsoft',
			'created_at' 		=> $date,
			'user_id' 			=> 1,
			'updated_at' 		=> $date,
			'deleted_at' 		=> NULL,
		);

		$manufacturers[] = array(
			'name'     		 	=> 'ASUS',
			'created_at' 		=> $date,
			'user_id' 			=> 1,
			'updated_at' 		=> $date,
			'deleted_at' 		=> NULL,
		);

		$manufacturers[] = array(
			'name'     		 	=> 'Dell',
			'created_at' 		=> $date,
			'user_id' 			=> 1,
			'updated_at' 		=> $date,
			'deleted_at' 		=> NULL,
		);


		// Delete all the blog posts
		DB::table('manufacturers')->truncate();

		// Insert the blog posts
		Manufacturer::insert($manufacturers);
	}

}
