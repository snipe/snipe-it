<?php

use Illuminate\Database\Migrations\Migration;

class AddFilenameToAssetLog extends Migration
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
            $table->text('filename')->nullable();
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
            $table->dropColumn('filename');
        });
    }
}
