<?php
class LicensesSeeder extends Seeder {


	public function run()
	{


		// Initialize empty array
		$license = array();

		$date = new DateTime;
		$license[] = array(
			'name'      => 'Tower',
			'serial'      => 'OMG-PWNED-SRY-WTF',
			'license_email'      => 'foo@example.com',
			'license_name'      => 'Andra Miller',
			'purchase_date'      => '2013-10-02',
			'purchase_cost'      => '49.99',
			'order_number'      => '987698576946',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);


		$license[] = array(
			'name'      => 'Adobe Photoshop',
			'serial'      => 'WTF-BBQ-PWNED-WTF',
			'license_email'      => 'bar@example.com',
			'license_name'      => 'Andrea Miller',
			'purchase_date'      => '2013-10-02',
			'purchase_cost'      => '199.99',
			'order_number'      => '7686868768',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);


		$license[] = array(
			'name'      => 'Pwnsauce',
			'serial'      => 'GEE-ARE-YOU-DUM',
			'license_email'      => 'blah@example.com',
			'license_name'      => 'Tits McGee',
			'purchase_date'      => '2013-10-02',
			'purchase_cost'      => '149.99',
			'order_number'      => '987698576946',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);

		$license[] = array(
			'name'      => 'BBedit',
			'serial'      => 'HAH-HAHA-HAHA',
			'license_email'      => 'me@example.com',
			'license_name'      => 'Alison Awesomesauce',
			'purchase_date'      => '2013-10-02',
			'purchase_cost'      => '98.99',
			'order_number'      => '6786678',
			'created_at' => $date->modify('-10 day'),
			'updated_at' => $date->modify('-3 day'),
			'user_id' => 1,
		);




		// Delete all the old data
		DB::table('licenses')->truncate();

		// Insert the new posts
		License::insert($license);
	}

}


