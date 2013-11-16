<?php

use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('licenses', function($table)
		{
		$table->increments('id');
		$table->string('name');
		$table->integer('model_id');
		$table->string('serial');
		$table->string('license_email');
		$table->string('license_name');
		$table->date('purchase_date')->nullable();
		$table->decimal('purchase_cost', 8, 2)->nullable();
		$table->string('order_number');
		$table->integer('assigned_to');
		$table->text('notes');
		$table->integer('user_id');
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
		Schema::drop('licenses');
	}

}