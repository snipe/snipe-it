<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssetNameToSettings extends Migration {

	 /**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function($table)
		{
			$table->integer('display_asset_name')->nullable()->default(NULL);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function($table)
		{
			$table->dropColumn('display_asset_name');
		});
	}

}
