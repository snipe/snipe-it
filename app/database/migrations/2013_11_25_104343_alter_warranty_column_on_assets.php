<?php

use Illuminate\Database\Migrations\Migration;

class AlterWarrantyColumnOnAssets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE assets CHANGE warrantee_months warranty_months int (3)');
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