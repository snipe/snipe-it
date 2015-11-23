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
			$table->string('ldap_enabled')->nullable()->default(NULL);
			$table->string('ldap_server')->nullable()->default(NULL);
			$table->string('ldap_uname')->nullable()->default(NULL);
			$table->longText('ldap_pword')->nullable()->default('eyJpdiI6IllDdUU1NUtXWGd1Tzg0dGdvY0JtU3JUS2VEcDhEbEs1UFB4cFh3STJEVVk9IiwidmFsdWUiOiJ2UFwvN1VIZ3hJZmJLdHNyejlIK0RVT0d5VUgyYVFIeEpFT0xyUExJQjRIWT0iLCJtYWMiOiI3MTIzNTliYzczMWJlNTViZmRiNDg0MjI5MDhkMzdhN2RkNmUxMmFiZDlmYWNmNGY3YzcxYzQ4MTY1NDIwN2UyIn0=');
			$table->string('ldap_basedn')->nullable()->default(NULL);
			$table->string('ldap_filter')->nullable()->default('cn=*');
			$table->string('ldap_username_field')->nullable()->default('samaccountname');
			$table->string('ldap_lname_field')->nullable()->default('sn');
			$table->string('ldap_fname_field')->nullable()->default('givenname');
			$table->string('ldap_auth_filter_query')->nullable()->default('uid=samaccountname');
			$table->integer('ldap_version')->nullable()->default(3);
			$table->string('ldap_active_flag')->nullable()->default(NULL);
			$table->string('ldap_emp_num')->nullable()->default(NULL);
			$table->string('ldap_email')->nullable()->default(NULL);
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
			$table->dropColumn('ldap_enabled');
			$table->dropColumn('ldap_server');
			$table->dropColumn('ldap_uname');
			$table->longText('ldap_pword');
			$table->dropColumn('ldap_basedn');
			$table->dropColumn('ldap_filter');
			$table->dropColumn('ldap_username_field');
			$table->dropColumn('ldap_lname_field');
			$table->dropColumn('ldap_fname_field');
			$table->dropColumn('ldap_auth_filter_query');
			$table->dropColumn('ldap_version');
			$table->dropColumn('ldap_active_flag');
			$table->dropColumn('ldap_emp_num');
			$table->dropColumn('ldap_email');
		});
	}

}
