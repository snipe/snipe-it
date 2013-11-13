<?php

class ManufacturersSeeder extends Seeder {

	public function run()
	{


		// Blog post 1
		$date = new DateTime;
		$manufacturers[] = array(
			'name'      => 'Apple'		
		);
		$manufacturers[] = array(
			'name'      => 'Microsoft'		
		);
		$manufacturers[] = array(
			'name'      => 'ASUS'		
		);
		$manufacturers[] = array(
			'name'      => 'Dell'		
		);

		
		// Delete all the blog posts
		DB::table('manufacturers')->truncate();

		// Insert the blog posts
		Manufacturer::insert($manufacturers);
	}

}
