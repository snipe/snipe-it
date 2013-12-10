<?php

class ModelsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$models = array();

		$date = new DateTime;
		$models[] = array(
			'name'      		=> 'MacBook Pro (13-inch, Mid 2012)',
			'manufacturer_id'   => '1',
			'category_id'      	=> '1',
			'modelno'      		=> 'MacBookPro9,2',
			'created_at' 		=> $date->modify('-10 day'),
			'updated_at' 		=> $date->modify('-3 day'),
			'depreciation_id' 	=> 1,
			'user_id'	 		=> 1,
			'eol' 				=> '36',
		);

		$models[] = array(
			'name'      		=> 'MacBook Pro (Retina, 13-inch, Late 2012)',
			'manufacturer_id'   => '1',
			'category_id'      	=> '1',
			'modelno'      		=> 'MacBookPro10,2',
			'created_at' 		=> $date->modify('-4 day'),
			'updated_at' 		=> $date->modify('-1 day'),
			'depreciation_id' 	=> 1,
			'user_id' 			=> 1,
			'eol' 				=> '36',
		);

		$models[] = array(
			'name'      		=> 'MacBook Pro (Retina, 13-inch, Early 2013)',
			'manufacturer_id'    => '2',
			'category_id'      	=> '1',
			'modelno'      		=> 'MacBookPro10,2',
			'created_at' 		=> $date->modify('-2 day'),
			'updated_at' 		=> $date,
			'depreciation_id' 	=> 1,
			'user_id' 			=> 1,
			'eol' 				=> '36',
		);


		$models[] = array(
			'name'      		=> 'MacBook Pro (Retina, 13-inch, Late 2013)',
			'manufacturer_id'   => '2',
			'category_id'      	=> '1',
			'modelno'      		=> 'MacBookPro11,1',
			'created_at' 		=> $date->modify('-2 day'),
			'updated_at' 		=> $date,
			'depreciation_id' 	=> 1,
			'user_id' 			=> 1,
			'eol' 				=> '24',
		);


		$models[] = array(
			'name'     	 		=> 'Inspiron 15 Non-Touch',
			'manufacturer_id'   => '4',
			'category_id'      	=> '1',
			'modelno'      		=> 'FNCWC16B',
			'created_at' 		=> $date->modify('-2 day'),
			'updated_at' 		=> $date,
			'depreciation_id' 	=> 1,
			'user_id' 			=> 1,
			'eol' 				=> '36',
		);

		$models[] = array(
			'name'      		=> '22-inch T897',
			'manufacturer_id'   => '4',
			'category_id'      	=> '5',
			'modelno'      		=> '78FNCWC16B',
			'created_at' 		=> $date->modify('-2 day'),
			'updated_at' 		=> $date,
			'depreciation_id' 	=> 1,
			'user_id' 			=> 1,
			'eol' 				=> '60',
		);




		// Delete all the old data
		DB::table('models')->truncate();

		// Insert the new posts
		Model::insert($models);
	}

}
