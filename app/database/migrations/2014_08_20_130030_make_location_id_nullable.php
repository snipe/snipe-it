<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLocationIdNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
            DB::statement('ALTER TABLE users MODIFY column location_id int NULL');
            
            DB::statement('ALTER TABLE suppliers MODIFY COLUMN state VARCHAR(64) NULL');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
