<?php

use Illuminate\Database\Migrations\Migration;

class AddUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asset_uploads', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('filename');
			$table->integer('asset_id');
			$table->string('filenotes')->nullable;
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
		Schema::drop('asset_uploads');
	}

}