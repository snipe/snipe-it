<?php

use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 Schema::create('models', function($table)
		 {
	        $table->increments('id');
	        $table->string('name');
	        $table->string('modelno');
	        $table->integer('manufacturer_id')->nullable();
	        $table->integer('category_id')->nullable();
	        $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('models');
	}

}