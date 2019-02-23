<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKitsLicensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('kits_licenses', function ($table) {
            $table->increments('id');
            $table->integer('kit_id')->nullable()->default(NULL); 
            $table->integer('license_id')->nullable()->default(NULL);    
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
		Schema::drop('kits_licenses');
	}

}
