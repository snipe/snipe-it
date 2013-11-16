<?php
class AssetsSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$asset = array();

		$date = new DateTime;
		$asset[] = array(
			'name'      => 'Alison MBP',
			'asset_tag'      => 'NNY287958796',
			'model_id'      => 1,
			'serial'      => 'WS905869046069',
			'purchase_date'      => '2013-10-02',
			'purchase_cost'      => '2435.99',
			'order_number'      => '987698576946',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => 'Brady MBP',
			'asset_tag'      => 'NNY78795566',
			'model_id'      => 2,
			'serial'      => 'WS9078686069',
			'purchase_date'      => '2012-01-02',
			'purchase_cost'      => '1999.99',
			'order_number'      => '657756',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => 'Noah MBP',
			'asset_tag'      => 'NNY678886',
			'model_id'      => 2,
			'serial'      => 'WS567688899',
			'purchase_date'      => '2011-11-29',
			'purchase_cost'      => '1999.99',
			'order_number'      => '54646546',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => 'Deborah Laptop',
			'asset_tag'      => 'NNY679789789',
			'model_id'      => 3,
			'serial'      => 'WS0909088883',
			'purchase_date'      => '2010-12-29',
			'purchase_cost'      => '3000.99',
			'order_number'      => 'TS7567657',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => '22-inch T546 Monitor',
			'asset_tag'      => 'NNY675757',
			'model_id'      => 3,
			'serial'      => 'WS1133453',
			'purchase_date'      => '2011-04-11',
			'purchase_cost'      => '199.99',
			'order_number'      => '897978900',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => 'Shanen Laptop',
			'asset_tag'      => 'NNY675757',
			'model_id'      => 4,
			'serial'      => 'WS768578683',
			'purchase_date'      => '2012-05-06',
			'purchase_cost'      => '1699.99',
			'order_number'      => '564564546',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => 'Sara Laptop',
			'asset_tag'      => 'NNY897987',
			'model_id'      => 2,
			'serial'      => 'WS7879879789',
			'purchase_date'      => '2012-05-06',
			'purchase_cost'      => '1699.99',
			'order_number'      => '564564546',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);


		$asset[] = array(
			'name'      => 'Ricky Laptop',
			'asset_tag'      => 'NNY987348r9',
			'model_id'      => 5,
			'serial'      => 'WS98479437593',
			'purchase_date'      => '2011-05-06',
			'purchase_cost'      => '3499.99',
			'order_number'      => '9080908',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => 'Andrew Laptop',
			'asset_tag'      => 'NNY989789',
			'model_id'      => 6,
			'serial'      => 'WS9080908',
			'purchase_date'      => '2012-09-18',
			'purchase_cost'      => '3499.99',
			'order_number'      => '09809809080',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);

		$asset[] = array(
			'name'      => 'Andra Laptop',
			'asset_tag'      => 'NNY8907979',
			'model_id'      => 6,
			'serial'      => 'WS9080908',
			'purchase_date'      => '2012-09-18',
			'purchase_cost'      => '3499.99',
			'order_number'      => '09809809080',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);


		$asset[] = array(
			'name'      => 'Win8 Test Laptop',
			'asset_tag'      => 'NNY879873497',
			'model_id'      => 6,
			'serial'      => '98708908098098',
			'purchase_date'      => '2011-09-18',
			'purchase_cost'      => '1299.99',
			'order_number'      => '980908909',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
			'assigned_to' => 1,
			'location_id' => 1,
		);






		// Delete all the old data
		DB::table('assets')->truncate();

		// Insert the new posts
		Asset::insert($asset);
	}

}


