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
		DB::update('update ' . DB::getTablePrefix() . 'assets SET assigned_to=NULL where assigned_to=0');

		Schema::table('status_labels', function ($table) {
			$table->boolean('deployable')->default(0);
			$table->boolean('pending')->default(0);
			$table->boolean('archived')->default(0);
			$table->text('notes')->nullable();
		});

		DB::statement('INSERT into ' . DB::getTablePrefix() . 'status_labels (user_id, name, deployable, pending, archived, notes) VALUES (1,"Pending",0,1,0,"These assets are not yet ready to be deployed, usually because of configuration or waiting on parts.")');
		DB::statement('INSERT into ' . DB::getTablePrefix() . 'status_labels (user_id, name, deployable, pending, archived, notes) VALUES (1,"Ready to Deploy",1,0,0,"These assets are ready to deploy.")');
		DB::statement('INSERT into ' . DB::getTablePrefix() . 'status_labels (user_id, name, deployable, pending, archived, notes) VALUES (1,"Archived",0,0,1,"These assets are no longer in circulation or viable.")');

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('status_labels', function ($table) {
			$table->dropColumn('deployable');
			$table->dropColumn('pending');
			$table->dropColumn('archived');
			$table->dropColumn('notes');

		});
	}

}
