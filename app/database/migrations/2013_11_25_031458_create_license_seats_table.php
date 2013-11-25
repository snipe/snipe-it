<?php

use Illuminate\Database\Migrations\Migration;

class CreateLicenseSeatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('license_seats', function($table)
		{
			$table->increments('id');
			$table->integer('license_id');
	        $table->integer('assigned_to');
	        $table->text('notes');
	        $table->integer('user_id');
	        $table->timestamps();
			$table->softDeletes();
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