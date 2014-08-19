<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFamilyIdToLicenses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('licenses', function(Blueprint $table)
		{
		// Add family_id to licenses table
                    $table->integer('family_id')->nullable();
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
		// Remove the family_id column
                    $table->dropColumn('family_id');
		});
	}

}
