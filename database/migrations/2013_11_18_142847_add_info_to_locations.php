<?php

use Illuminate\Database\Migrations\Migration;

class AddInfoToLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function ($table) {

            $table->string('address', 80)->nullable();
            $table->string('address2', 80)->nullable();
            $table->string('zip', 10)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function ($table) {

            $table->dropColumn('address');
            $table->dropColumn('address2');
            $table->dropColumn('zip');

        });
    }

}
