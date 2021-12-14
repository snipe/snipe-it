<?php


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupLdapToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('ldap_grp_basedn')->nullable()->default(NULL);
			$table->string('ldap_grp_filter')->nullable()->default('objectclass=group');
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
            $table->dropColumn('ldap_grp_basedn');
			$table->dropColumn('ldap_grp_filter');
        });
    }
}
