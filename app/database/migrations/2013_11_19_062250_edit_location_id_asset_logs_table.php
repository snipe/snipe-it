<?php

use Illuminate\Database\Migrations\Migration;

class EditLocationIdAssetLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$prefix=DB::getTablePrefix();
        DB::statement('ALTER TABLE '.$prefix.'asset_logs MODIFY location_id int(11) null');
        DB::statement('ALTER TABLE '.$prefix.'asset_logs MODIFY added_on timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');

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
