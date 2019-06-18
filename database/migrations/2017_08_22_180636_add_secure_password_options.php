<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecurePasswordOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('pwd_secure_uncommon')->default('0');
            $table->string('pwd_secure_complexity')->nullable()->default(NULL);
            $table->integer('pwd_secure_min')->default('8');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('pwd_secure_uncommon');
            $table->dropColumn('pwd_secure_complexity');
            $table->dropColumn('pwd_secure_min');
        });
    }
}
