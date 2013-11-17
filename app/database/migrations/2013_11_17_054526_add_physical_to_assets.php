<?php

use Illuminate\Database\Migrations\Migration;

class AddPhysicalToAssets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('assets', function($table)
		{
			$table->boolean('physical')->default(1);
			$table->dropColumn('checkedout_to')->nullable();

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
	}

}