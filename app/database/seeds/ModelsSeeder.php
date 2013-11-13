<?php

class ModelsSeeder extends Seeder {

	public function run()
	{
		

		// Initialize empty array
		$models = array();

		// Blog post 1
		$date = new DateTime;
		$models[] = array_merge($common, array(
			'name'      => 'MacBook Pro - 15-inch, early 2013',
			'manufacturer_id'      => '1',
			'category_id'      => '1',
			'modelno'      => 'JHKGJGF',			
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-10 day'),
		));

		// Blog post 2
		$date = new DateTime;
		$models[] = array_merge($common, array(
			'name'      => 'MacBook Pro - 13-inch, early 2013',
			'manufacturer_id'      => '1',
			'category_id'      => '1',
			'modelno'      => 'FHKGJGF',
			'created_at' => $date->modify('-4 day'),
			'updated_at' => $date->modify('-4 day'),
		));

		// Blog post 3
		$date = new DateTime;
		$models[] = array_merge($common, array(
			'name'      => 'MacBook Pro - 15-inch, late 2013',
			'manufacturer_id'      => '2',
			'category_id'      => '1',
			'modelno'      => 'DHKGJGF',
			'created_at' => $date->modify('-2 day'),
			'updated_at' => $date->modify('-2 day'),
		));

		// Delete all the blog posts
		DB::table('models')->truncate();

		// Insert the blog posts
		Model::insert($models);
	}

}
