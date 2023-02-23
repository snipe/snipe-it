<?php

use Illuminate\Database\Migrations\Migration;

class AddEolOnModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('models', function ($table) {
            $table->integer('eol')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('models', function ($table) {
            $table->dropColumn('old');
        });
    }
}
