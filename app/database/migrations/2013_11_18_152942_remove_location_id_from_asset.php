<?php

use Illuminate\Database\Migrations\Migration;

class RemoveLocationIdFromAsset extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assets', function($table)
		{
			$table->dropColumn('location_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assets', function($table)
		{
			$table->integer('location_id');
		});
	}

}