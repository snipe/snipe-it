<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAssignedToColumnsToAllowNull extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Manually altering the columns, because Schema Builder doesn't allow you to alter columns
		// This probably works the way I think it does

		if (Schema::hasColumn('assets', 'assigned_to')) DB::update('ALTER TABLE `assets` CHANGE `assigned_to` `assigned_to` INT(11) NULL');
		else Schema::table('assets', function($table)
		{
			$table->integer('assigned_to')->nullable();
		});

		if (Schema::hasColumn('licenses', 'assigned_to')) DB::update('ALTER TABLE `licenses` CHANGE `assigned_to` `assigned_to` INT(11) NULL');
		else Schema::table('licenses', function($table)
		{
			$table->integer('assigned_to')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
