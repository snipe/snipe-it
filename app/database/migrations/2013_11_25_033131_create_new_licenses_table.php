<?php

use Illuminate\Database\Migrations\Migration;

class CreateNewLicensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('licenses', function($table)
		{
			$table->increments('id');
			$table->string('name');
	        $table->string('serial');
	        $table->date('purchase_date')->nullable();
	        $table->decimal('purchase_cost', 8, 2)->nullable();
	        $table->string('order_number');
	        $table->integer('seats')->default(1);
	        $table->text('notes');
	        $table->integer('user_id');
	        $table->integer('depreciation_id');
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
		Schema::drop('licenses');
	}

}