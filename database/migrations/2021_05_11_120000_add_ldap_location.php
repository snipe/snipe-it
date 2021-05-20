<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLdapLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ldap_location')->after('ldap_dept')->nullable();
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('ldap_location_toggle')->after('ldap_location')->default(0);
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
            $table->dropColumn('ldap_location');
        });
        Schema::table('settings', function ($table) {
            $table->dropColumn('ldap_location_toggle');
        });
    }
}
