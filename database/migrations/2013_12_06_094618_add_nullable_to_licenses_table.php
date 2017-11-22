<?php

use Illuminate\Database\Migrations\Migration;

class AddNullableToLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licenses', function ($table) {
            $table->string('order_number', 50)->nullable()->change();
            $table->string('notes', 255)->nullable()->change();
            $table->string('license_name', 120)->nullable()->change();
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
    }
}
