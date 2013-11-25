<?php

use Illuminate\Database\Migrations\Migration;

class AddTypeToActionlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('asset_logs', function($table)
		{
			$table->enum('asset_type', array('software', 'hardware'));
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
		Schema::table('asset_logs', function($table)
		{
			$table->dropColumn('asset_type');
		});
	}

}