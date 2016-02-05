<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationCheckout extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assets', function ($table) {
 			$table->integer('assigned_location')->nullable()->default(NULL);
 		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assets', function ($table) {
            $table->dropColumn('assigned_location');
        });
	}

}
