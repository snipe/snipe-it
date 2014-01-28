<?php

use Illuminate\Database\Migrations\Migration;

class AddQrCodeToSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function($table)
		{
			$table->integer('qr_code')->nullable()->default(NULL);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function($table)
		{
			$table->dropColumn('qr_code');
		});
	}

}