<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImportLdapSettings extends Migration {

	/**
	 * Migration to pull in LDAP settings from ldap.config into database.
	 *
	 * @return void
	 */
	public function up()
	{

    $settings = Setting::first();

    // Only update the settings record if there IS an LDAP Config
    // AND the Settings table doesn't already have LDAP settings in it

		if ((Config::get('ldap.url'))  && ($settings) && ($settings->ldap_server)) {

      $settings->ldap_enabled = 1;
      $settings->ldap_server = Config::get('ldap.url');
      $settings->ldap_uname = Config::get('ldap.username');
      $settings->ldap_pword = Crypt::encrypt(Config::get('ldap.password'));
      $settings->ldap_basedn = Config::get('ldap.basedn');
      $settings->ldap_filter = Config::get('ldap.filter');
      $settings->ldap_username_field = Config::get('ldap.result.username');
      $settings->ldap_lname_field = Config::get('ldap.result.last.name');
      $settings->ldap_fname_field = Config::get('ldap.result.first.name');
      $settings->ldap_auth_filter_query = Config::get('ldap.authentication.filter.query');
      $settings->ldap_version = Config::get('ldap.version');
      $settings->ldap_active_flag = Config::get('ldap.result.active.flag');
      $settings->ldap_emp_num = Config::get('ldap.result.emp.num');
      $settings->ldap_email = Config::get('ldap.result.email');

      // Save the imported settings
      if ($settings->save()) {
        echo 'LDAP settings imported into database'."\n";

        // Copy the old LDAP config file to prevent any future confusion
        if (@copy(app_path().'/config/'.app()->environment().'/ldap.php', app_path().'/config/'.app()->environment().'/deprecated.ldap.php')) {

            if (@unlink(app_path().'/config/'.app()->environment().'/ldap.php')) {
              echo 'Original LDAP file archived to '.app_path().'/config/'.app()->environment().'/deprecated.ldap.php'."\n";
            } else {
              echo 'Could not archive LDAP config file'."\n";
            }

        } else {
            echo 'Could not archive LDAP config file'."\n";
        }

      }

    }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

    if (@copy(app_path().'/config/'.app()->environment().'/deprecated.ldap.php', app_path().'/config/'.app()->environment().'/ldap.php')) {
      echo 'Un-archived LDAP config file'."\n";
      @unlink(app_path().'/config/'.app()->environment().'/deprecated.ldap.php');

    } else {
      echo 'Could not un-archive LDAP config file. Manually rename it instead.'."\n";
    }
	}

}
