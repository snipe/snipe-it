<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Setting;
use Exception;
use Input;
use Log;


class Ldap extends Model
{

    /**
     * Makes a connection to LDAP using the settings in Admin > Settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return connection
     */

    public static function connectToLdap()
    {

        $ldap_host    = Setting::getSettings()->ldap_server;
        $ldap_version = Setting::getSettings()->ldap_version;
        $ldap_server_cert_ignore = Setting::getSettings()->ldap_server_cert_ignore;


        // If we are ignoring the SSL cert we need to setup the environment variable
        // before we create the connection
        if ($ldap_server_cert_ignore) {
            putenv('LDAPTLS_REQCERT=never');
        }

        // Connecting to LDAP
        $connection = @ldap_connect($ldap_host) or die("Could not connect to {$ldap_host}");

        if (!$connection) {
            throw new Exception('Could not connect to LDAP server at '.$ldap_host.': '.ldap_error($connection));
        }

        // Needed for AD
        ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, $ldap_version);

        return $connection;
    }


    /**
     * Binds/authenticates the user to LDAP, and returns their attributes.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $username
     * @param $password
     * @param bool|false $user
     * @return bool true    if the username and/or password provided are valid
     *              false   if the username and/or password provided are invalid
     *         array of ldap_attributes if $user is true
     *
     */
    static function findAndBindUserLdap($username, $password)
    {
        $settings = Setting::getSettings();
        $connection = Ldap::connectToLdap();
        $ldap_username_field     = $settings->ldap_username_field;
        $baseDn      = $settings->ldap_basedn;

        if ($settings->is_ad =='1')
        {

            // In case they haven't added an AD domain
            if ($settings->ad_domain == '') {
                $userDn      = $username.'@'.$settings->email_domain;
            } else {
               $userDn      = $username.'@'.$settings->ad_domain;
            }

        } else {
            $userDn      = $ldap_username_field.'='.$username.','.$settings->ldap_basedn;
        }


        $filterQuery = $settings->ldap_auth_filter_query . $username;

        if (!$ldapbind = @ldap_bind($connection, $userDn, $password)) {
            return false;
        }

        if (!$results = ldap_search($connection, $baseDn, $filterQuery)) {
            throw new Exception('Could not search LDAP: ');
        }

        if (!$entry = ldap_first_entry($connection, $results)) {
            return false;
        }

        if (!$user =  array_change_key_case(ldap_get_attributes($connection, $entry), CASE_LOWER)) {
            return false;
        }

        return $user;

    }


    /**
     * Binds/authenticates an admin to LDAP for LDAP searching/syncing.
     * Here we also return a better error if the app key is donked.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param bool|false $user
     * @return bool true    if the username and/or password provided are valid
     *              false   if the username and/or password provided are invalid
     *
     */
    static function bindAdminToLdap($connection)
    {

        $ldap_username     = Setting::getSettings()->ldap_uname;

        // Lets return some nicer messages for users who donked their app key, and disable LDAP
        try {
            $ldap_pass    = \Crypt::decrypt(Setting::getSettings()->ldap_pword);
        } catch (Exception $e) {

            throw new Exception('Your app key has changed! Could not decrypt LDAP password using your current app key, so LDAP authentication has been disabled. Login with a local account, update the LDAP password and re-enable it in Admin > Settings.');
        }


        if (!$ldapbind = @ldap_bind($connection, $ldap_username, $ldap_pass)) {
            throw new Exception('Could not bind to LDAP: '.ldap_error($connection));
        }

    }



    /**
     * Create user from LDAP attributes
     *
     * @param $ldapatttibutes
     * @return array|bool
     */
    static function createUserFromLdap($ldapatttibutes)
    {
        //Get LDAP attribute config
        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;
        $ldap_result_email = Setting::getSettings()->ldap_email;

        // Get LDAP user data
        $item = array();
        $item["username"] = isset($ldapatttibutes[$ldap_result_username][0]) ? $ldapatttibutes[$ldap_result_username][0] : "";
        $item["employee_number"] = isset($ldapatttibutes[$ldap_result_emp_num][0]) ? $ldapatttibutes[$ldap_result_emp_num][0] : "";
        $item["lastname"] = isset($ldapatttibutes[$ldap_result_last_name][0]) ? $ldapatttibutes[$ldap_result_last_name][0] : "";
        $item["firstname"] = isset($ldapatttibutes[$ldap_result_first_name][0]) ? $ldapatttibutes[$ldap_result_first_name][0] : "";
        $item["email"] = isset($ldapatttibutes[$ldap_result_email][0]) ? $ldapatttibutes[$ldap_result_email][0] : "" ;

        // Create user from LDAP data
        if (!empty($item["username"])) {
            $newuser = new User;
            $newuser->first_name = $item["firstname"];
            $newuser->last_name = $item["lastname"];
            $newuser->username = $item["username"];
            $newuser->email = $item["email"];
            $newuser->password = bcrypt(Input::get("password"));
            $newuser->activated = 1;
            $newuser->ldap_import = 1;
            $newuser->notes = 'Imported on first login from LDAP';
            //dd($newuser);
            if ($newuser->save()) {
                return true;
            } else {
                LOG::debug('Could not create user.'.$newuser->getErrors());
                exit;
            }
        }

        return false;

    }

    static function findLdapUsers() {

        $ldapconn = Ldap::connectToLdap();
        $ldap_bind = Ldap::bindAdminToLdap($ldapconn);
        $base_dn = Setting::getSettings()->ldap_basedn;
        $filter = Setting::getSettings()->ldap_filter;

        // Set up LDAP pagination for very large databases
        // @author Richard Hofman
        $page_size = 500;
        $cookie = '';
        $result_set = array();
        $global_count = 0;

        // Perform the search
        do {
            // Paginate (non-critical, if not supported by server)
            ldap_control_paged_result($ldapconn, $page_size, false, $cookie);

            $search_results = ldap_search($ldapconn, $base_dn, '('.$filter.')');

            if (!$search_results) {
                return redirect()->route('users')->with('error', trans('admin/users/message.error.ldap_could_not_search').ldap_error($ldapconn));
            }

            // Get results from page
            $results = ldap_get_entries($ldapconn, $search_results);
            if (!$results) {
                return redirect()->route('users')->with('error', trans('admin/users/message.error.ldap_could_not_get_entries').ldap_error($ldapconn));
            }

            // Add results to result set
            $global_count += $results['count'];
            $result_set = array_merge($result_set, $results);

            ldap_control_paged_result_response($ldapconn, $search_results, $cookie);

        } while ($cookie !== null && $cookie != '');


        // Clean up after search
        $result_set['count'] = $global_count;
        $results = $result_set;
        ldap_control_paged_result($ldapconn, 0);

        return $results;


    }




}
