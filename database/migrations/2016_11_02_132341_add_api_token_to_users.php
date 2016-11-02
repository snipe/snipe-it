<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiTokenToUsers extends Migration
{
    public function up()
    {
        // Update the users table
        Schema::table('users', function ($table) {
            $table->softDeletes();
            $table->string('api_token', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Update the users table
        Schema::table('users', function ($table) {
            $table->dropColumn('api_token');
        });
    }
}
