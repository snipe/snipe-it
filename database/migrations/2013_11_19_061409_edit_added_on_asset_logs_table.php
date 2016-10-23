<?php

use Illuminate\Database\Migrations\Migration;

class EditAddedOnAssetLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('ALTER TABLE  ' . DB::getTablePrefix() . 'asset_logs MODIFY added_on timestamp null');

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
