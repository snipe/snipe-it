<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AssetsSeeder');
		$this->call('CategoriesSeeder');
		$this->call('LocationsSeeder');
		$this->call('ManufacturersSeeder');
		$this->call('ModelsSeeder');
		$this->call('DepreciationsSeeder');
		$this->call('StatuslabelsSeeder');
		$this->call('SettingsSeeder');
		$this->call('LicensesSeeder');
		$this->call('LicenseSeatsSeeder');
		$this->call('ActionlogSeeder');
	}

}
