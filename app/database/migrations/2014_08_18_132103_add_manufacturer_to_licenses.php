<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManufacturerToLicenses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('licenses', function(Blueprint $table)
		{
		// Add manufacturer_id to licenses table
                    $table->integer('manufacturer_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('licenses', function(Blueprint $table)
		{
		// Remove the manufacture_id column
                    $table->dropColumn('manufacturer_id');
		});
	}

}
