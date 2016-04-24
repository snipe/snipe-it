<?php

class AuthController extends BaseController
{
    /**
     * Account sign in.
     *
     * @return View
     */
    public function getSignin()
    {
        // Is the user logged in?
        if (Sentry::check()) {
            return Redirect::route('account');
        }

        // Show the page
        return View::make('frontend.auth.signin');
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
    function ldap($username, $password, $returnUser = false) {

        $ldaphost    = Setting::getSettings()->ldap_server;
        $ldaprdn     = Setting::getSettings()->ldap_uname;
        $ldappass    = Crypt::decrypt(Setting::getSettings()->ldap_pword);
        $baseDn      = Setting::getSettings()->ldap_basedn;
        $filterQuery = Setting::getSettings()->ldap_auth_filter_query . $username;
        $ldapversion = Setting::getSettings()->ldap_version;
        $ldap_server_cert_ignore = Setting::getSettings()->ldap_server_cert_ignore;

        // If we are ignoring the SSL cert we need to setup the environment variable
        // before we create the connection
        if($ldap_server_cert_ignore) {
            putenv('LDAPTLS_REQCERT=never');
        }

	    // Connecting to LDAP
        $connection = ldap_connect($ldaphost) or die("Could not connect to {$ldaphost}");
        // Needed for AD
        ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION,$ldapversion);

        try {
            if ($connection) {
                // binding to ldap server
                $ldapbind = ldap_bind($connection, $ldaprdn, $ldappass);
                if ( ($results = @ldap_search($connection, $baseDn, $filterQuery)) != false ) {
                    $entry = ldap_first_entry($connection, $results);
                    if ( ($userDn = @ldap_get_dn($connection, $entry)) != false ) {
                        if( ($isBound = ldap_bind($connection, $userDn, $password)) == "true") {
                            return $returnUser ?
                                array_change_key_case(ldap_get_attributes($connection, $entry),CASE_LOWER)
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
    function createUserFromLdap($ldapatttibutes){
        //Get LDAP attribute config
        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;
        $ldap_result_email = Setting::getSettings()->ldap_email;

        //Get LDAP user data
        $item = array();
        $item["username"] = isset( $ldapatttibutes[$ldap_result_username][0] ) ? $ldapatttibutes[$ldap_result_username][0] : "";
        $item["employee_number"] = isset( $ldapatttibutes[$ldap_result_emp_num][0] ) ? $ldapatttibutes[$ldap_result_emp_num][0] : "";
        $item["lastname"] = isset( $ldapatttibutes[$ldap_result_last_name][0] ) ? $ldapatttibutes[$ldap_result_last_name][0] : "";
        $item["firstname"] = isset( $ldapatttibutes[$ldap_result_first_name][0] ) ? $ldapatttibutes[$ldap_result_first_name][0] : "";
        $item["email"] = isset( $ldapatttibutes[$ldap_result_email][0] ) ? $ldapatttibutes[$ldap_result_email][0] : "" ;

        //create user
        if(!empty($item["username"])) {
            //$pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

            $newuser = array(
                'first_name' => $item["firstname"],
                'last_name' => $item["lastname"],
                'username' => $item["username"],
                'email' => $item["email"],
                'employee_num' => $item["employee_number"],
                'password' => Input::get("password"), //$pass,
                'activated' => 1,
                'location_id' => null,
                'permissions' => ["user" => 1], //'{"user":1}',
                'notes' => 'Imported from LDAP'
            );
            Sentry::createUser($newuser);
            /*DB::table('users')->insert($newuser);
            $updateuser = Sentry::findUserByLogin($item["username"]);
            $updateuser->setHasher(new Cartalyst\Sentry\Hashing\BcryptHasher);

            // Update the user details
            $updateuser->password = Input::get('password');

            // Update the user
            $updateuser->save(); */
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
    public function postSignin()
    {
        // Declare the rules for the form validation
        $rules = array(
            'username'    => 'required',
            'password' => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }
        try {

            // Should we even check for LDAP users?
            if (Setting::getSettings()->ldap_enabled=='1') {

              LOG::debug("LDAP is enabled.");
              // Check if the user exists in the database
              $user = User::where('username','=',Input::get('username'))->whereNull('deleted_at')->first();
              LOG::debug("Sentry lookup complete");


              // The user does not exist in the database. Try to get them from LDAP.
              // If user does not exist and authenticates sucessfully with LDAP we
              // will create it on the fly and sign in with default permissions
              if(!$user){
                  LOG::debug("Local user ".Input::get('username')." does not exist");
                  if($userattr = $this->ldap(Input::get('username'), Input::get('password'),true) ){
                    LOG::debug("Creating local user from authenticated LDAP user.");
                    $credentials = $this->createUserFromLdap($userattr);
                  } else {
                    LOG::debug("User did not authenticate correctly against LDAP. No local user was created.");
                  }

              // If the user exists and they were imported from LDAP already
              } else {

                LOG::debug("Local user ".Input::get('username')." exists in database. Authenticating existing user against LDAP.");

                if ($this->ldap(Input::get('username'), Input::get('password')) ) {
                    LOG::debug("Valid LDAP login. Updating the local data.");
                    $sentryuser=Sentry::findUserById($user->id); //need the Sentry object, not the Eloquent object, to access critical password hashing functions
                    $sentryuser->password = Input::get('password');
                    $sentryuser->save();

                } else {
                  LOG::debug("User did not authenticate correctly against LDAP. Local user was not updated.");
                }// End LDAP auth

              } // End if(!user)

            // NO LDAP enabled - just try to login the user normally
            }

            LOG::debug("Authenticating user against database.");
            // Try to log the user in
            if (!Sentry::authenticate(Input::only('username', 'password'), Input::get('remember-me', 0))) {
              LOG::debug("Local authentication failed.");
              throw new Cartalyst\Sentry\Users\UserNotFoundException();
            }

            // Get the page we were before
            $redirect = Session::get('loginRedirect', 'account');

            // Unset the page we were before from the session
            Session::forget('loginRedirect');

            // Redirect to the users page
            return Redirect::to($redirect)->with('success', Lang::get('auth/message.signin.success'));

        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            LOG::debug("Local authentication: User ".Input::get('username')." not found");
            $this->messageBag->add('username', Lang::get('auth/message.account_not_found'));

        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            LOG::debug("Local authentication: Password for ".Input::get('username')." is incorrect.");
            $this->messageBag->add('username', Lang::get('auth/message.account_not_found'));

        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            LOG::debug("Local authentication: User not activated");
            $this->messageBag->add('username', Lang::get('auth/message.account_not_activated'));

        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            LOG::debug("Local authentication: Account suspended");
            $this->messageBag->add('username', Lang::get('auth/message.account_suspended'));

        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            LOG::debug("Local authentication: Account banned.");
            $this->messageBag->add('username', Lang::get('auth/message.account_banned'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }


    /**
     * User account activation page.
     *
     * @param  string  $actvationCode
     * @return
     */
    public function getActivate($activationCode = null)
    {
        // Is the user logged in?
        if (Sentry::check()) {
            return Redirect::route('account');
        }

        try {
            // Get the user we are trying to activate
            $user = Sentry::getUserProvider()->findByActivationCode($activationCode);

            // Try to activate this user account
            if ($user->attemptActivation($activationCode)) {
                // Redirect to the login page
                return Redirect::route('signin')->with('success', Lang::get('auth/message.activate.success'));
            }

            // The activation failed.
            $error = Lang::get('auth/message.activate.error');
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $error = Lang::get('auth/message.activate.error');
        }

        // Ooops.. something went wrong
        return Redirect::route('signin')->with('error', $error);
    }

    /**
     * Forgot password page.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        // Show the page
        return View::make('frontend.auth.forgot-password');
    }

    /**
     * Forgot password form processing page.
     *
     * @return Redirect
     */
    public function postForgotPassword()
    {
        // Declare the rules for the validator
        $rules = array(
            'username' => 'required',
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::route('forgot-password')->withInput()->withErrors($validator);
        }

        try {
            // Get the user password recovery code
            if (!$user = Sentry::getUserProvider()->findByLogin(Input::get('username'))) {
                $user = User::where('email','=',Input::get('username'));
            }

            $reset = $user->getResetPasswordCode();

            // Data to be used on the username view
            $data = array(
                'user'              => $user,
                'forgotPasswordUrl' => URL::route('forgot-password-confirm', $reset),
            );

            $user->reset_password_code = $reset;
            $user->save();


            if ($user->email) {
                // Send the activation code through username
                Mail::send('emails.forgot-password', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->subject('Account Password Recovery');
                });
            }

        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::route('forgot-password')->withInput()->with('error', $e->getMessage());
            // Even though the username was not found, we will pretend
            // we have sent the password reset code through username,
            // this is a security measure against hackers.
        }

        //  Redirect to the forgot password
        return Redirect::route('forgot-password')->with('success', Lang::get('auth/message.forgot-password.success'));
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param  string  $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($passwordResetCode = null)
    {

        try {
            // Find the user using the password reset code
            $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);
        } catch(Cartalyst\Sentry\Users\UserNotFoundException $e) {
            // Redirect to the forgot password page
            //return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }

        // Show the page
        return View::make('frontend.auth.forgot-password-confirm');
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param  string  $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm($passwordResetCode = null)
    {
        // Declare the rules for the form validation
        $rules = array(
            'password'         => 'required|between:10,32',
            'password_confirm' => 'required|same:password'
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::route('forgot-password-confirm', $passwordResetCode)->withInput()->withErrors($validator);
        }

        try {
            // Find the user using the password reset code
            $user = Sentry::getUserProvider()->findByResetPasswordCode($passwordResetCode);

            // Attempt to reset the user password
            if ($user->attemptResetPassword($passwordResetCode, Input::get('password'))) {
                // Password successfully reseted
                return Redirect::route('signin')->with('success', Lang::get('auth/message.forgot-password-confirm.success'));
            } else {
                // Ooops.. something went wrong
                return Redirect::route('signin')->with('error', Lang::get('auth/message.forgot-password-confirm.error'));
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        // Log the user out
        Sentry::logout();

        // Redirect to the users page
        return Redirect::route('home')->with('success', 'You have successfully logged out!');
    }

}
