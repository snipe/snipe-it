<?php
class AssetsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$asset = array();

		$date = new DateTime;

		// Pending (status_id is null, assigned_to = 0)
		$asset[] = array(
			'name'      	=> 'Shanen MBP',
			'asset_tag'     => 'NNY2878796',
			'model_id'      => 1,
			'serial'      	=> 'WS90585666669',
			'purchase_date' => '2013-10-02',
			'purchase_cost' => '2435.99',
			'order_number'  => '987698576946',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> NULL,
		);

		// Pending (status_id is null, assigned_to = 0)
		$asset[] = array(
			'name'      	=> 'Michael MBP',
			'asset_tag'     => 'NNY28633396',
			'model_id'      => 1,
			'serial'      	=> 'WS905823226669',
			'purchase_date' => '2013-10-02',
			'purchase_cost' => '2435.99',
			'order_number'  => '987698576946',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> NULL,
		);


		// RTD (status_id =0, assigned_to = 0)
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
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> 0,
		);

		// RTD (status_id =0, assigned_to = 0)
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
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> 0,
		);

		// RTD (status_id =0, assigned_to = 0)
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
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> 0,
		);


		// Deployed (status_id =0, assigned_to > 0)
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
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> 0,
		);

		// Deployed (status_id =0, assigned_to > 0)
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
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> 0,
		);

		// Undeployable (status_id > 0, assigned_to = 0)
		$asset[] = array(
			'name'      	=> 'Broke-Ass Laptop',
			'asset_tag'     => 'NNY67567775',
			'model_id'      => 2,
			'serial'      	=> 'WS89080890',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 2,
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> '3',
		);

		// Undeployable (status_id > 0, assigned_to = 0)
		$asset[] = array(
			'name'      	=> 'Maybe Broke-Ass Laptop',
			'asset_tag'     => 'NNY6755667775',
			'model_id'      => 2,
			'serial'      	=> 'WS45689080890',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 0,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> '2',
		);

		// Undeployable (status_id > 0, assigned_to = 0)
		$asset[] = array(
			'name'      	=> 'Completely Facacta Laptop',
			'asset_tag'     => 'NNY6564567775',
			'model_id'      => 2,
			'serial'      	=> 'WS99689080890',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 1,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> '4',
		);

		// Undeployable (status_id > 0, assigned_to = 0)
		$asset[] = array(
			'name'      	=> 'Drunken Shanenigans Laptop',
			'asset_tag'     => 'NNY6564567775',
			'model_id'      => 2,
			'serial'      	=> 'WS99689080890',
			'purchase_date' => '2012-01-02',
			'purchase_cost' => '1999.99',
			'order_number'  => '657756',
			'created_at' 	=> $date->modify('-10 day'),
			'updated_at' 	=> $date->modify('-3 day'),
			'user_id' 		=> 1,
			'assigned_to' 	=> 0,
			'physical' 		=> 1,
			'archived' 		=> 1,
			'license_name'	=> NULL,
			'license_email'	=> NULL,
			'status_id'	=> '3',
		);




		// Delete all the old data
		DB::table('assets')->truncate();

		// Insert the new posts
		Asset::insert($asset);
	}

}


