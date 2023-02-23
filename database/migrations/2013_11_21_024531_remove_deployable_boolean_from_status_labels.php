<?php

use Illuminate\Database\Migrations\Migration;

class RemoveDeployableBooleanFromStatusLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('status_labels', function ($table) {
            $table->dropColumn('deployable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_labels', function ($table) {
            $table->boolean('deployable');
        });
    }
}
