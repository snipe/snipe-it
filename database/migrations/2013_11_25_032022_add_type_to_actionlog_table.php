<?php

use Illuminate\Database\Migrations\Migration;

class AddTypeToActionlogTable extends Migration
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
            $table->string('asset_type')->nullable();
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
            $table->dropColumn('asset_type');
        });
    }
}
