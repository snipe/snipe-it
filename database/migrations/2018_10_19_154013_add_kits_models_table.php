<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKitsModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('kits_models', function ($table) {
            $table->increments('id');
            $table->integer('kit_id')->nullable()->default(NULL); 
            $table->integer('model_id')->nullable()->default(NULL);    
            $table->integer('quantity')->default(1);
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
		//
		Schema::drop('kits_models');
	}

}
