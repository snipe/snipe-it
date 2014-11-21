<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLicenceType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		 DB::statement('ALTER TABLE licenses MODIFY COLUMN serial TEXT');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		 DB::statement('ALTER TABLE licenses MODIFY COLUMN serial VARCHAR(255)');
	}

}
