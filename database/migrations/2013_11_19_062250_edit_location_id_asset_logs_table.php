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

        // Schema::table('asset_logs', function ($table) {
        //   $table->string('location_id')->nullable()->change();
        //   $table->dateTime('added_on',11)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(0)'))->change();
        // });
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
