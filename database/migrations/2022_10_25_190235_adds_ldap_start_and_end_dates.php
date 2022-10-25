<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsLdapStartAndEndDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
                    $table->string('ldap_start_date')->after('ldap_country')->nullable();
                    $table->string('ldap_end_date')->after('ldap_start_date')->nullable();

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
            $table->dropColumn('ldap_start_date');
            $table->dropColumn('ldap_end_date');
        });
    }
}
