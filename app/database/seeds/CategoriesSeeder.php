<?php

class CategoriesSeeder extends Seeder {

	public function run()
	{


		$date = new DateTime;
		$category[] = array(
			'name'      => 'Laptops',
			'parent'      => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$date = new DateTime;
		$category[] = array(
			'name'      => 'Desktops',
			'parent'      => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$date = new DateTime;
		$category[] = array(
			'name'      => 'Tablets',
			'parent'      => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$date = new DateTime;
		$category[] = array(
			'name'      => 'Phones',
			'parent'      => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$date = new DateTime;
		$category[] = array(
			'name'      => 'Monitors',
			'parent'      => '0',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);


		// Delete all the blog posts
		DB::table('categories')->truncate();

		// Insert the blog posts
		Category::insert($category);
	}

}
