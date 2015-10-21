<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldFieldset extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('custom_field_fieldset', function(Blueprint $table)
		{
			$table->integer('custom_field_id');
			$table->integer('fieldset_id');
			
			$table->integer('order');
			$table->boolean('required');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_field_fieldset');
		// Schema::table('custom_field_fieldset', function(Blueprint $table)
		// {
		// 	//
		// });
	}

}
