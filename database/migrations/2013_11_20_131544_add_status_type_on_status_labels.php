<?php

use Illuminate\Database\Migrations\Migration;

class AddStatusTypeOnStatusLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('status_labels', function ($table) {
            $table->boolean('deployable')->nullable();
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
            $table->dropColumn('deployable');
        });
    }
}
