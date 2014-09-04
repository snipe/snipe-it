<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAssetStatusidPendingReady extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            // Update the asset status_ids to match the new 'table' values
            DB::table('assets')->whereNull('status_id')->update(array('status_id' => 1));
            DB::table('assets')->where('status_id', 0)->update(array('status_id' => 2));
            //DB::statement("UPDATE `assets` SET `status_id`='1' WHERE `status_id`=NULL;");
            //DB::statement("UPDATE `assets` SET `status_id`='2' WHERE `status_id`='0';");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            //
            // Revert the asset status_ids to the old assumed values
            DB::table('assets')->where('status_id', 1)->update(array('status_id' =>NULL));
            DB::table('assets')->where('status_id', 2)->update(array('status_id' => 0));
	}
        
}
