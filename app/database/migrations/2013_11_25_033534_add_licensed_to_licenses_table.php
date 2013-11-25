<?php

use Illuminate\Database\Migrations\Migration;

class AddLicensedToLicensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('licenses', function($table)
		{
			$table->string('license_name');
			$table->string('license_email');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('licenses', function($table)
		{
			$table->dropColumn('license_name');
			$table->dropColumn('license_email');
		});
	}

}