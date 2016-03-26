<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\Setting;
use App\Models\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Log;
use View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use ThrottlesLogins;

    // This tells the auth controller to use username instead of email address
    protected $username = 'username';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    function showLoginForm()
    {
      // Is the user logged in?
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }

      // Show the page
        return View::make('auth.login');
    }


    /**
     * Authenticates a user to LDAP
     *
     * @param $username
     * @param $password
     * @param bool|false $returnUser
     * @return bool true    if the username and/or password provided are valid
     *              false   if the username and/or password provided are invalid
     *         array of ldap_attributes if $returnUser is true
     */
    function ldap($username, $password, $returnUser = false)
    {

        $ldaphost    = Setting::getSettings()->ldap_server;
        $ldaprdn     = Setting::getSettings()->ldap_uname;
        $ldappass    = \Crypt::decrypt(Setting::getSettings()->ldap_pword);
        $baseDn      = Setting::getSettings()->ldap_basedn;
        $filterQuery = Setting::getSettings()->ldap_auth_filter_query . $username;
        $ldapversion = Setting::getSettings()->ldap_version;
        $ldap_server_cert_ignore = Setting::getSettings()->ldap_server_cert_ignore;

        // If we are ignoring the SSL cert we need to setup the environment variable
        // before we create the connection
        if ($ldap_server_cert_ignore) {
            putenv('LDAPTLS_REQCERT=never');
        }

        // Connecting to LDAP
        $connection = ldap_connect($ldaphost) or die("Could not connect to {$ldaphost}");
        // Needed for AD
        ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, $ldapversion);

        try {
            if ($connection) {
              // binding to ldap server
                $ldapbind = ldap_bind($connection, $ldaprdn, $ldappass);
                if (($results = @ldap_search($connection, $baseDn, $filterQuery)) != false) {
                    $entry = ldap_first_entry($connection, $results);
                    if (($userDn = @ldap_get_dn($connection, $entry)) != false) {
                        if (($isBound = ldap_bind($connection, $userDn, $password)) == "true") {
                            return $returnUser ?
                            array_change_key_case(ldap_get_attributes($connection, $entry), CASE_LOWER)
                            : true;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            LOG::error($e->getMessage());
        }
           ldap_close($connection);
            return false;
    }

    /**
     * Create user from LDAP attributes
     *
     * @param $ldapatttibutes
     * @return array|bool
     */
    function createUserFromLdap($ldapatttibutes)
    {
        //Get LDAP attribute config
        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;
        $ldap_result_email = Setting::getSettings()->ldap_email;

        //Get LDAP user data
        $item = array();
        $item["username"] = isset($ldapatttibutes[$ldap_result_username][0]) ? $ldapatttibutes[$ldap_result_username][0] : "";
        $item["employee_number"] = isset($ldapatttibutes[$ldap_result_emp_num][0]) ? $ldapatttibutes[$ldap_result_emp_num][0] : "";
        $item["lastname"] = isset($ldapatttibutes[$ldap_result_last_name][0]) ? $ldapatttibutes[$ldap_result_last_name][0] : "";
        $item["firstname"] = isset($ldapatttibutes[$ldap_result_first_name][0]) ? $ldapatttibutes[$ldap_result_first_name][0] : "";
        $item["email"] = isset($ldapatttibutes[$ldap_result_email][0]) ? $ldapatttibutes[$ldap_result_email][0] : "" ;

        //create user
        if (!empty($item["username"])) {
            //$pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

            $newuser = array(
              'first_name' => $item["firstname"],
              'last_name' => $item["lastname"],
              'username' => $item["username"],
              'email' => $item["email"],
              'employee_num' => $item["employee_number"],
              'password' => bcrypt(Input::get("password")), //$pass,
              'activated' => 1,
              'permissions' => ["user" => 1], //'{"user":1}',
              'notes' => 'Imported from LDAP'
            );
            User::save($newuser);

        } else {
            throw new Cartalyst\Sentry\Users\UserNotFoundException();
        }

        //$item["note"] = "<strong>created</strong>";
        $credentials = array(
            'username' => $item["username"],
            'password' => Input::get("password")//$pass,
        );
        return $credentials;
    }


    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function login()
    {
        $validator = $this->validator(Input::all());

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Should we even check for LDAP users?
        if (Setting::getSettings()->ldap_enabled=='1') {

            LOG::debug("LDAP is enabled.");
          // Check if the user exists in the database
            $user = User::where('username', '=', Input::get('username'))->whereNull('deleted_at')->first();
            LOG::debug("Auth lookup complete");


          // The user does not exist in the database. Try to get them from LDAP.
          // If user does not exist and authenticates sucessfully with LDAP we
          // will create it on the fly and sign in with default permissions
            if (!$user) {
                LOG::debug("Local user ".Input::get('username')." does not exist");
                if ($userattr = $this->ldap(Input::get('username'), Input::get('password'), true)) {
                    LOG::debug("Creating local user from authenticated LDAP user.");
                    $credentials = $this->createUserFromLdap($userattr);
                } else {
                    LOG::debug("User did not authenticate correctly against LDAP. No local user was created.");
                }

            // If the user exists and they were imported from LDAP already
            } else {

                LOG::debug("Local user ".Input::get('username')." exists in database. Authenticating existing user against LDAP.");

                if ($this->ldap(Input::get('username'), Input::get('password'))) {
                    LOG::debug("Valid LDAP login. Updating the local data.");
                    $user = User::find($user->id); //need the Sentry object, not the Eloquent object, to access critical password hashing functions
                    $user->password = bcrypt(Input::get('password'));
                    $user->ldap_import = 1;
                    $user->save();

                } else {
                    LOG::debug("User did not authenticate correctly against LDAP. Local user was not updated.");
                }// End LDAP auth

            } // End if(!user)

        // NO LDAP enabled - just try to login the user normally
        }

        LOG::debug("Authenticating user against database.");
        // Try to log the user in
        if (!Auth::attempt(Input::only('username', 'password'), Input::get('remember-me', 0))) {
            LOG::debug("Local authentication failed.");
          // throw new Cartalyst\Sentry\Users\UserNotFoundException();
            return Redirect::back()->withInput()->with('error', trans('auth/message.account_not_found'));
        }

        // Get the page we were before
        $redirect = \Session::get('loginRedirect', 'home');

        // Unset the page we were before from the session
        \Session::forget('loginRedirect');

        // Redirect to the users page
        return Redirect::to($redirect)->with('success', trans('auth/message.signin.success'));

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function logout()
    {
        // Log the user out
        Auth::logout();

        // Redirect to the users page
        return Redirect::route('home')->with('success', 'You have successfully logged out!');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required',
            'password' => 'required',
        ]);
    }
}
