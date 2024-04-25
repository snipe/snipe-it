<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLdapCompanyAndOuSyncOptionToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ldap_company')->after('ldap_jobtitle')->nullable()->default(null);
            $table->string('ldap_ou_sync_type')->after('ldap_location')->default('location');
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
            $table->dropColumn('ldap_company');
            $table->dropColumn('ldap_ou_sync_type');
        });
    }
}
