<?php

use Illuminate\Database\Migrations\Migration;

class AddDepreciateToLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('licenses', function ($table) {
            $table->boolean('depreciate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenses', function ($table) {
            $table->dropColumn('depreciate');
        });
    }
}
