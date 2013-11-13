<?php

class CategoriesSeeder extends Seeder {

	public function run()
	{


		// Blog post 1
		$date = new DateTime;
		$categories[] = array(
			'name'      => 'Laptops'		
		);
		$categories[] = array(
			'name'      => 'Desktops'		
		);
		$categories[] = array(
			'name'      => 'Monitors'		
		);
		$categories[] = array(
			'name'      => 'Phones'		
		);

		
		// Delete all the blog posts
		DB::table('categories')->truncate();

		// Insert the blog posts
		Category::insert($categories);
	}

}
