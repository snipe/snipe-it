<?php

class CommentsSeeder extends Seeder {

	public function run()
	{
		// Initialize empty array
		$comments = array();

		// Blog Post 1 comments
		$date = new DateTime;
		$comments[] = array(
			'user_id'    => 1,
			'post_id'    => 1,
			'content'    => file_get_contents(__DIR__.'/comment1-content.txt'),
			'created_at' => $date->modify('-9 day +1 hour'),
			'updated_at' => $date->modify('-9 day +1 hour'),
		);
		$date = new DateTime;
		$comments[] = array(
			'user_id'    => 2,
			'post_id'    => 1,
			'content'    => file_get_contents(__DIR__.'/comment2-content.txt'),
			'created_at' => $date->modify('-7 day +2 hour'),
			'updated_at' => $date->modify('-7 day +2 hour'),
		);
		$date = new DateTime;
		$comments[] = array(
			'user_id'    => 1,
			'post_id'    => 1,
			'content'    => file_get_contents(__DIR__.'/comment3-content.txt'),
			'created_at' => $date->modify('-2 day +3 hour'),
			'updated_at' => $date->modify('-2 day +3 hour'),
		);

		// Blog Post 2 comments
		$date = new DateTime;
		$comments[] = array(
			'user_id'    => 1,
			'post_id'    => 2,
			'content'    => file_get_contents(__DIR__.'/comment1-content.txt'),
			'created_at' => $date->modify('-2 day +1 hour'),
			'updated_at' => $date->modify('-2 day +1 hour'),
		);
		$date = new DateTime;
		$comments[] = array(
			'user_id'    => 2,
			'post_id'    => 2,
			'content'    => file_get_contents(__DIR__.'/comment2-content.txt'),
			'created_at' => $date->modify('-1 day +2 hour'),
			'updated_at' => $date->modify('-1 day +2 hour'),
		);

		// Blog Post 3 comments
		$date = new DateTime;
		$comments[] = array(
			'user_id'    => 1,
			'post_id'    => 3,
			'content'    => file_get_contents(__DIR__.'/comment1-content.txt'),
			'created_at' => $date->modify('-1 day +1 hour'),
			'updated_at' => $date->modify('-1 day +1 hour'),
		);

		// Delete all the posts comments
		DB::table('comments')->truncate();

		// Insert the posts comments
		Comment::insert($comments);
	}

}
