<?php

use Illuminate\Database\Migrations\Migration;

class CreateStatusLabels extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('status_labels', function($table)
		{
			$table->increments('id');
			$table->string('name',100);
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
		Schema::drop('status_labels');
	}

}