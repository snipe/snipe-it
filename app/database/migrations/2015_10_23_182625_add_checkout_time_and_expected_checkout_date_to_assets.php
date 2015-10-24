<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckoutTimeAndExpectedCheckoutDateToAssets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assets', function(Blueprint $table)
		{
			//
			$answer=$table->dateTime('last_checkout')->nullable();
			$table->date('expected_checkin')->nullable();
		});
		DB::statement("UPDATE assets SET last_checkout=(SELECT MAX(created_at) FROM asset_logs WHERE asset_logs.id=assets.id AND action_type='checkout') WHERE assigned_to IS NOT NULL");
		DB::statement("UPDATE assets SET expected_checkin=(SELECT expected_checkin FROM asset_logs WHERE asset_logs.id=assets.id AND action_type='checkout' ORDER BY id DESC limit 1) WHERE assigned_to IS NOT NULL");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assets', function(Blueprint $table)
		{
			//
			$table->dropColumn('last_checkout');
			$table->dropColumn('expected_checkin');
		});
	}

}
