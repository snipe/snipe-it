<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpectedCheckinDateToAssetLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('asset_logs', function ($table) {
            $table->date('expected_checkin')->nullable()->default(NULL);
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('asset_logs', function(Blueprint $table)
		{
			$table->dropColumn('expected_checkin');
		});

	}

}
