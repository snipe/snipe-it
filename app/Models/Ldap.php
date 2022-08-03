<?php

namespace App\Models;

use App\Models\Setting;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Input;
use Log;

/***********************************************
 * TODOS:
 *
 * First off, we should probably make it so that the main LDAP thing we're using is an *instance* of this class,
 * rather than the static methods we use here. We should probably load up that class with its settings, so we
 * don't have to explicitly refer to them so often.
 *
 * Then, we should probably look at embedding some of the logic we use elsewhere into here - the various methods
 * should either return a User or false, or other things like that. Don't make the consumers of this class reach
 * into its guts. While that conflates this model with the User model, I think having the appropriate logic for
 * turning LDAP people into Users ought to belong here, so it's easier on the consumer of this class.
 *
 * We're probably going to have to eventually make it so that Snipe-IT users can define multiple LDAP servers,
 * and having this as a more instance-oriented class will be a step in the right direction.
 ***********************************************/

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
        $ldap_host = Setting::getSettings()->ldap_server;
        $ldap_version = Setting::getSettings()->ldap_version ?: 3;
        $ldap_server_cert_ignore = Setting::getSettings()->ldap_server_cert_ignore;
        $ldap_use_tls = Setting::getSettings()->ldap_tls;

        // If we are ignoring the SSL cert we need to setup the environment variable
        // before we create the connection
        if ($ldap_server_cert_ignore == '1') {
            putenv('LDAPTLS_REQCERT=never');
        }

        // If the user specifies where CA Certs are, make sure to use them
        if (env('LDAPTLS_CACERT')) {
            putenv('LDAPTLS_CACERT='.env('LDAPTLS_CACERT'));
        }

        $connection = @ldap_connect($ldap_host);

        if (! $connection) {
            throw new Exception('Could not connect to LDAP server at '.$ldap_host.'. Please check your LDAP server name and port number in your settings.');
        }

        // Needed for AD
        ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, $ldap_version);
        ldap_set_option($connection, LDAP_OPT_NETWORK_TIMEOUT, 20);

        if (Setting::getSettings()->ldap_client_tls_cert && Setting::getSettings()->ldap_client_tls_key) {
            ldap_set_option(null, LDAP_OPT_X_TLS_CERTFILE, Setting::get_client_side_cert_path());
            ldap_set_option(null, LDAP_OPT_X_TLS_KEYFILE, Setting::get_client_side_key_path());
        }

        if ($ldap_use_tls=='1') {
            ldap_start_tls($connection);
        }


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
     */
    public static function findAndBindUserLdap($username, $password)
    {
        $settings = Setting::getSettings();
        $connection = self::connectToLdap();
        $ldap_username_field = $settings->ldap_username_field;
        $baseDn = $settings->ldap_basedn;

        // FIND the user first, then attempt to log in as them using the appropriate attribute
        $filterQuery = $settings->ldap_auth_filter_query.$username;
        $filter = Setting::getSettings()->ldap_filter; //FIXME - this *does* respect the ldap filter, but I believe that AdLdap2 did *not*.
        $filterQuery = "({$filter}({$filterQuery}))"; // FIXME - this makes an incorrect LDAP filter if there is no filter query

        \Log::debug('Filter query: '.$filterQuery);


        if (! self::bindAdminToLdap($connection) ) { //
            \Log::debug("Uh, we could *NOT* bind as admin?! I don't understand how this ever worked.");
            return false; // also FIXME? Maybe this one is OK?
        }
        \Log::debug("Well, I guess we at least bound as somebody?");
        if (! $results = ldap_search($connection, $baseDn, $filterQuery)) {
            throw new Exception('Could not search LDAP: '); // FIXME - I'm worried these early returns are somehow bad, in that they might disclose whether or not users exist?
        }

        if (! $entry = ldap_first_entry($connection, $results)) {
            throw new Exception('Could not retrieve LDAP entry'); // TODO - should this throw an exception or just return false?
            return false;
        }

        if (! $user = ldap_get_attributes($connection, $entry)) {
            throw new Exception('Could not fetch LDAP attributes'); // TODO - should this throw an exception or just return false?
            return false;
        }

        if ( ldap_next_entry($connection, $entry) !== false ) { //if there's a 'next' entry, then that's more than one - failure.
            throw new Exception('Too many entries returned'); // (new) - TODO - should this throw an exception or just return false?
            return false; //
        }

        \Log::debug("Entry retrieved was: ".print_r($user, true));
        \Log::debug("The calculated LDAP username IS: ".print_r(array_change_key_case($user)[$ldap_username_field],true));

        $username = array_change_key_case($user)[$ldap_username_field][0]; // TODO - is this right?
        $userDn = $ldap_username_field.'='.$username;
        if ( $settings->ldap_append_basedn_to_username ) { // TODO - we *could* actually disable/enable this field based on whether AD is on or not? (it will be ignored if AD is on, right?)
            $userDn .= ','.$settings->ldap_basedn;
        }
        \Log::debug("initial username we think is: $userDn");
        // *Now* we should try to bind as that found user
        // first, AD has its own username-assembly system
        if ($settings->is_ad == '1') {
            // Check if they are using the userprincipalname for the username field.
            // If they are, we can skip building the UPN to authenticate against AD
            if ($ldap_username_field == 'userprincipalname') {
                $userDn = $username;
            } else {
                // TODO - we no longer respect the "add AD Domain to username" checkbox, but it still exists in settings.
                // We should probably just eliminate that checkbox to avoid confusion.
                // We let it sit in the DB, unused, to facilitate people downgrading (if they decide to).
                // Hopefully, in a later release, we can remove it from the settings.
                // This logic instead just means that if we're using UPN, we don't append ad_domain, if we aren't, then we do.
                // Hopefully that should handle all of our use cases, but if not we can backport our old logic.
                $userDn = ($settings->ad_domain != '') ? $username.'@'.$settings->ad_domain : $username.'@'.$settings->email_domain;
            }
        }

        if (! $ldapbind = @ldap_bind($connection, $userDn, $password)) {
            \Log::debug("Failed to log in to: $userDn with password '$password'");
            throw new Exception("Unable to bind as user: $userDn");
        }
        \Log::debug("Status of binding user: $userDn to directory: (directly!) ".($ldapbind ? "success" : "FAILURE"));

        return array_change_key_case($user);
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
     */
    public static function bindAdminToLdap($connection)
    {
        $ldap_username = Setting::getSettings()->ldap_uname;

        // Lets return some nicer messages for users who donked their app key, and disable LDAP
        try {
            $ldap_pass = \Crypt::decrypt(Setting::getSettings()->ldap_pword);
        } catch (Exception $e) {
            throw new Exception('Your app key has changed! Could not decrypt LDAP password using your current app key, so LDAP authentication has been disabled. Login with a local account, update the LDAP password and re-enable it in Admin > Settings.');
        }

        if (! $ldapbind = @ldap_bind($connection, $ldap_username, $ldap_pass)) {
            throw new Exception('Could not bind to LDAP: '.ldap_error($connection));
        }
        return $ldapbind; // will always be true - if it were false, we would've thrown an Exception
    }


    /**
     * Parse and map LDAP attributes based on settings
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     *
     * @param $ldapatttibutes
     * @return array|bool
     */
    public static function parseAndMapLdapAttributes($ldapattributes)
    {
        //Get LDAP attribute config
        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;
        $ldap_result_email = Setting::getSettings()->ldap_email;
        $ldap_result_phone = Setting::getSettings()->ldap_phone;
        $ldap_result_jobtitle = Setting::getSettings()->ldap_jobtitle;
        $ldap_result_country = Setting::getSettings()->ldap_country;
        $ldap_result_dept = Setting::getSettings()->ldap_dept;
        $ldap_result_manager = Setting::getSettings()->ldap_manager;
        // Get LDAP user data
        $item = [];
        $item['username'] = isset($ldapattributes[$ldap_result_username][0]) ? $ldapattributes[$ldap_result_username][0] : '';
        $item['employee_number'] = isset($ldapattributes[$ldap_result_emp_num][0]) ? $ldapattributes[$ldap_result_emp_num][0] : '';
        $item['lastname'] = isset($ldapattributes[$ldap_result_last_name][0]) ? $ldapattributes[$ldap_result_last_name][0] : '';
        $item['firstname'] = isset($ldapattributes[$ldap_result_first_name][0]) ? $ldapattributes[$ldap_result_first_name][0] : '';
        $item['email'] = isset($ldapattributes[$ldap_result_email][0]) ? $ldapattributes[$ldap_result_email][0] : '';
        $item['telephone'] = isset($ldapattributes[$ldap_result_phone][0]) ? $ldapattributes[$ldap_result_phone][0] : '';
        $item['jobtitle'] = isset($ldapattributes[$ldap_result_jobtitle][0]) ? $ldapattributes[$ldap_result_jobtitle][0] : '';
        $item['country'] = isset($ldapattributes[$ldap_result_country][0]) ? $ldapattributes[$ldap_result_country][0] : '';
        $item['department'] = isset($ldapattributes[$ldap_result_dept][0]) ? $ldapattributes[$ldap_result_dept][0] : '';
        $item['manager'] = isset($ldapattributes[$ldap_result_manager][0]) ? $ldapattributes[$ldap_result_manager][0] : '';

        return $item;
    }

    /**
     * Create user from LDAP attributes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $ldapatttibutes
     * @return array|bool
     */
    public static function createUserFromLdap($ldapatttibutes, $password)
    {
        $item = self::parseAndMapLdapAttributes($ldapatttibutes);

        // Create user from LDAP data
        if (! empty($item['username'])) {
            $user = new User;
            $user->first_name = $item['firstname'];
            $user->last_name = $item['lastname'];
            $user->username = $item['username'];
            $user->email = $item['email'];

            if (Setting::getSettings()->ldap_pw_sync == '1') {

                $user->password = bcrypt($password);
            } else {
                $pass = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 25);
                $user->password = bcrypt($pass);
            }

            $user->activated = 1;
            $user->ldap_import = 1;
            $user->notes = 'Imported on first login from LDAP';

            if ($user->save()) {
                return $user;
            } else {
                LOG::debug('Could not create user.'.$user->getErrors());
                throw new Exception('Could not create user: '.$user->getErrors());
            }
        }

        return false;
    }

    /**
     * Searches LDAP
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $base_dn
     * @param $count
     * @param $filter
     * @return array|bool
     */
    public static function findLdapUsers($base_dn = null, $count = -1, $filter = null)
    {
        $ldapconn = self::connectToLdap();
        self::bindAdminToLdap($ldapconn);
        // Default to global base DN if nothing else is provided.
        if (is_null($base_dn)) {
            $base_dn = Setting::getSettings()->ldap_basedn;
        }
        if($filter === null) {
            $filter = Setting::getSettings()->ldap_filter;
        }

        // Set up LDAP pagination for very large databases
        $page_size = 500;
        $cookie = '';
        $result_set = [];
        $global_count = 0;

        // Perform the search
        do {

            if ($filter != '' && substr($filter, 0, 1) != '(') { // wrap parens around NON-EMPTY filters that DON'T have them, for back-compatibility with AdLdap2-based filters
                $filter = "($filter)";
            } elseif ($filter == '') {
                $filter = '(cn=*)';
            }

            // HUGE thanks to this article: https://stackoverflow.com/questions/68275972/how-to-get-paged-ldap-queries-in-php-8-and-read-more-than-1000-entries
            // which helped me wrap my head around paged results!
            // if a $count is set and it's smaller than $page_size then use that as the page size
            $ldap_controls = [];
            //if($count == -1) { //count is -1 means we have to employ paging to query the entire directory
                $ldap_controls = [['oid' => LDAP_CONTROL_PAGEDRESULTS, 'iscritical' => false, 'value' => ['size'=> $count == -1||$count>$page_size ? $page_size : $count, 'cookie' => $cookie]]];
            //}
            $search_results = ldap_search($ldapconn, $base_dn, $filter, [], 0, /* $page_size */ -1, -1, LDAP_DEREF_NEVER, $ldap_controls); // TODO - I hate the @, and I hate that we get a full page even if we ask for 10 records. Can we use an ldap_control?
            \Log::debug("LDAP search executed successfully.");
            if (! $search_results) {
                return redirect()->route('users.index')->with('error', trans('admin/users/message.error.ldap_could_not_search').ldap_error($ldapconn)); // TODO this is never called in any routed context - only from the Artisan command. So this redirect will never work.
            }

            $errcode = null;
            $matcheddn = null;
            $errmsg = null;
            $referrals = null;
            $controls = [];
            ldap_parse_result($ldapconn, $search_results, $errcode , $matcheddn , $errmsg , $referrals, $controls);
            if (isset($controls[LDAP_CONTROL_PAGEDRESULTS]['value']['cookie'])) {
                // You need to pass the cookie from the last call to the next one
                $cookie = $controls[LDAP_CONTROL_PAGEDRESULTS]['value']['cookie'];
                \Log::debug("okay, at least one more page to go!!!");
            } else {
                \Log::debug("okay, we're out of pages - no cookie (or empty cookie) was passed");
                $cookie = '';
            }
            // Empty cookie means last page
        
            // Get results from page
            $results = ldap_get_entries($ldapconn, $search_results);
            if (! $results) {
                return redirect()->route('users.index')->with('error', trans('admin/users/message.error.ldap_could_not_get_entries').ldap_error($ldapconn)); // TODO this is never called in any routed context - only from the Artisan command. So this redirect will never work.
            }

            // Add results to result set
            $global_count += $results['count'];
            $result_set = array_merge($result_set, $results);
            \Log::debug("Total count is: $global_count");

        } while ($cookie !== null && $cookie != '' && ($count == -1 || $global_count < $count)); // some servers don't even have pagination, and some will give you more results than you asked for, so just see if you have enough.

        // Clean up after search
        $result_set['count'] = $global_count; // TODO: I would've figured you could just count the array instead?
        $results = $result_set;

        return $results;
    }
}
