<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEmailNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		DB::statement('ALTER TABLE `'.DB::getTablePrefix().'users` MODIFY `email` varchar(255) DEFAULT NULL;');

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		DB::statement('ALTER TABLE `'.DB::getTablePrefix().'users` MODIFY `email` varchar(255) NOT NULL;');
	}

}
