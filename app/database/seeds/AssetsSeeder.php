<?php
class AssetsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$asset = array();

		$date = new DateTime;
		$asset[] = array(
			'name'      	=> 'Alison MBP',
			'asset_tag'     => 'NNY287958796',
			'model_id'      => 1,
			'serial'      	=> 'WS905869046069',
			'purchase_date' => '2013-10-02',
			'purchase_cost' => '2435.99',
			'order_number'  => '987698576946',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
			'assigned_to' 	=> 1,
			'physical' 		=> 1,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
		);

		$asset[] = array(
			'name'      	=> 'Brady MBP',
			'asset_tag'     => 'NNY78795566',
			'model_id'      => 2,
			'serial'      	=> 'WS9078686069',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
			'assigned_to' 	=> 1,
			'physical' 		=> 1,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
		);

		$asset[] = array(
			'name'      	=> 'Deborah MBP',
			'asset_tag'     => 'NNY65756756775',
			'model_id'      => 2,
			'serial'      	=> 'WS9078686069',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '699.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 2,
			'assigned_to' 	=> 2,
			'physical' 		=> 1,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
		);

		$asset[] = array(
			'name'      	=> 'Photoshop CS6',
			'asset_tag'     => 'NNY65756756775',
			'model_id'      => 8,
			'serial'      	=> 'OMG-WTF-SRSLY-BBQ',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 2,
			'assigned_to' 	=> 2,
			'physical' 		=> 0,
			'license_name'	=> 'Alison Giasnotto',
			'license_email'	=> 'snipe@snipe.net',
		);

		$asset[] = array(
			'name'      	=> 'Git Tower',
			'asset_tag'     => 'NNY65756756775',
			'model_id'      => 7,
			'serial'      	=> 'OMG-WTF-SRSLY-BBQ',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 2,
			'assigned_to' 	=> 2,
			'physical' 		=> 0,
			'license_name'	=> 'Alison Giasnotto',
			'license_email'	=> 'me@example.com',
		);

		$asset[] = array(
			'name'      	=> 'Sara MBP',
			'asset_tag'     => 'NNY6897856775',
			'model_id'      => 2,
			'serial'      	=> 'WS87897998Q',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 2,
			'assigned_to' 	=> 2,
			'physical' 		=> 1,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
		);

		$asset[] = array(
			'name'      	=> 'Ben MBP',
			'asset_tag'     => 'NNY67567775',
			'model_id'      => 2,
			'serial'      	=> 'WS89080890',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 2,
			'assigned_to' 	=> 2,
			'physical' 		=> 1,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
		);



		// Delete all the old data
		DB::table('assets')->truncate();

		// Insert the new posts
		Asset::insert($asset);
	}

}


