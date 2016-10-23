<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateDataToNewStatuses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// get newly added statuses from last migration
		$statuses = DB::select('select * from ' . DB::getTablePrefix() . 'status_labels where name="Pending" OR name="Ready to Deploy"');


		foreach ($statuses as $status) {
			if ($status->name =="Pending") {
				$pending_id = array($status->id);
			} elseif ($status->name =="Ready to Deploy") {
				$rtd_id = array($status->id);
			}
		}

		// Pending
		$pendings = DB::select('select * from ' . DB::getTablePrefix() . 'assets where status_id IS NULL AND physical=1 ');

			foreach ($pendings as $pending) {
				DB::update('update ' . DB::getTablePrefix() . 'assets set status_id = ? where status_id IS NULL AND physical=1',$pending_id);

			}


		// Ready to Deploy
		$rtds = DB::select('select * from ' . DB::getTablePrefix() . 'assets where status_id = 0 AND physical=1 ');

		foreach ($rtds as $rtd) {
				//DB::update('update users set votes = 100 where name = ?', array('John'));
				DB::update('update ' . DB::getTablePrefix() . 'assets set status_id = ? where status_id = 0 AND physical=1',$rtd_id);

			}




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
