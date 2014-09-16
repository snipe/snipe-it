<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntityIdToLocations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('locations', function(Blueprint $table)
		{
                    // Add entity_id field -> tied to the entities table
                    $table->smallInteger('entity_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('locations', function(Blueprint $table)
		{
                    //Remove the entity_id field
                    $table->dropColumn('entity_id');
		});
	}

}
