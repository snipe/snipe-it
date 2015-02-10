<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixBadAssignedToIds extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::statement('update ' . DB::getTablePrefix() . 'assets SET assigned_to=NULL where assigned_to=0');
		DB::statement('update ' . DB::getTablePrefix() . 'licenses SET assigned_to=NULL where assigned_to=0');

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
