<?php

class PostsSeeder extends Seeder {

	public function run()
	{
		// Common data
		$common = array(
			'user_id' => 1,
			'content' => file_get_contents(__DIR__ . '/post-content.txt'),
		);

		// Initialize empty array
		$posts = array();

		// Blog post 1
		$date = new DateTime;
		$posts[] = array_merge($common, array(
			'title'      => 'Lorem ipsum dolor sit amet',
			'slug'       => 'lorem-ipsum-dolor-sit-amet',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-10 day'),
		));

		// Blog post 2
		$date = new DateTime;
		$posts[] = array_merge($common, array(
			'title'      => 'Vivendo suscipiantur vim te vix',
			'slug'       => 'vivendo-suscipiantur-vim-te-vix',
			'created_at' => $date->modify('-4 day'),
			'updated_at' => $date->modify('-4 day'),
		));

		// Blog post 3
		$date = new DateTime;
		$posts[] = array_merge($common, array(
			'title'      => 'In iisque similique reprimique eum',
			'slug'       => 'in-iisque-similique-reprimique-eum',
			'created_at' => $date->modify('-2 day'),
			'updated_at' => $date->modify('-2 day'),
		));

		// Delete all the blog posts
		DB::table('posts')->truncate();

		// Insert the blog posts
		Post::insert($posts);
	}

}
