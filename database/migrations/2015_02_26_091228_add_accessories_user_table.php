<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccessoriesUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('accessories_users', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(NULL); 
            $table->integer('accessory_id')->nullable()->default(NULL);    
            $table->integer('assigned_to')->nullable()->default(NULL);       
            $table->timestamps();
        });
        
        Schema::table('accessories', function ($table) {
			$table->integer('location_id')->nullable()->default(NULL);
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
		Schema::drop('accessories_users');
		
		Schema::table('accessories', function ($table) {
			$table->dropColumn('location_id');
		});

	}

}
