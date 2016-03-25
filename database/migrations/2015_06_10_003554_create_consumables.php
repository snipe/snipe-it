<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		 Schema::create('consumables', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable()->default(NULL);
            $table->integer('category_id')->nullable()->default(NULL);
			      $table->integer('location_id')->nullable()->default(NULL);
            $table->integer('user_id')->nullable()->default(NULL);
            $table->integer('qty')->default(0);
            $table->boolean('requestable')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::table('asset_logs', function ($table) {
			$table->integer('consumable_id')->nullable()->default(NULL);
		});

		Schema::create('consumables_users', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(NULL);
            $table->integer('consumable_id')->nullable()->default(NULL);
            $table->integer('assigned_to')->nullable()->default(NULL);
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
		Schema::drop('consumables');

		Schema::table('asset_logs', function ($table) {
			$table->dropColumn('consumable_id');
		});

		Schema::drop('consumables_users');

	}

}
