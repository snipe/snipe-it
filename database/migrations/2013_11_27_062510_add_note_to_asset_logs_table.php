<?php

use Illuminate\Database\Migrations\Migration;

class AddNoteToAssetLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('asset_logs', function ($table) {
            $table->text('note')->nullable();
        });
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
            $table->dropColumn('note');
        });
    }
}
