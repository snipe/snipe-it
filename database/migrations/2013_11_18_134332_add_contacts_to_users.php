<?php

use Illuminate\Database\Migrations\Migration;

class AddContactsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('location_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('jobtitle')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('location_id');
            $table->dropColumn('phone');
            $table->dropColumn('jobtitle');

        });

    }

}
