<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLdapFieldsToSettings extends Migration {

	/**
	 * Run the migrations.
	 * 
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			$table->text('ldap_server')->nullable()->default(NULL);
			$table->text('ldap_uname')->nullable()->default(NULL);
			$table->text('ldap_pword')->nullable()->default(NULL);
			$table->text('ldap_basedn')->nullable()->default(NULL);
			$table->text('ldap_username')->nullable()->default(NULL);
			$table->text('ldap_lname')->nullable()->default(NULL);
			$table->text('ldap_fname')->nullable()->default(NULL);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			$table->dropColumn('ldap_server');
			$table->dropColumn('ldap_uname');
			$table->dropColumn('ldap_pword');
			$table->dropColumn('ldap_basedn');
			$table->dropColumn('ldap_username');
			$table->dropColumn('ldap_lname');
			$table->dropColumn('ldap_fname');
		});
	}

}
