<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAcceptedAtToAcceptanceId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

		Schema::table('asset_logs', function ($table) {
			$table->integer('accepted_id')->nullable()->default(NULL);
		});

		$results = DB::select('select invitation.id AS invitation_id, acceptance.id AS acceptance_id FROM '.DB::getTablePrefix().'asset_logs invitation INNER JOIN '.DB::getTablePrefix().'asset_logs acceptance ON (invitation.checkedout_to=acceptance.checkedout_to AND invitation.asset_id=acceptance.asset_id) WHERE invitation.action_type="checkout" AND acceptance.action_type="accepted"');


		foreach ($results as $result) {
			$update = DB::update('update '.DB::getTablePrefix().'asset_logs set accepted_id=? where id=?', [$result->acceptance_id, $result->invitation_id]);
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
		Schema::table('asset_logs', function ($table) {
			$table->dropColumn('accepted_id');
		});

	}

}
