<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddInventorystatusToAssetstatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('status_labels', function(Blueprint $table)
		{
		//
                $table->integer('inventory_state_id')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('status_labels', function(Blueprint $table)
		{
                //
                    $table->dropColumn('inventory_state_id');
		});
	}

}
