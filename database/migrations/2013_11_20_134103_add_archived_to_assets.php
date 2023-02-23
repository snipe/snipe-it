<?php

use Illuminate\Database\Migrations\Migration;

class AddArchivedToAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function ($table) {
            $table->boolean('archived')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function ($table) {
            $table->dropColumn('archived');
        });
    }
}
