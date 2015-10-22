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
     * @return  true    if the username and/or password provided are valid
     *          false   if the username and/or password provided are invalid
     *
     */
    function ldap($username, $password) {

        $ldaphost    = Config::get('ldap.url');
        $ldaprdn     = Config::get('ldap.username');
        $ldappass    = Config::get('ldap.password');
        $baseDn      = Config::get('ldap.basedn');
        $filterQuery = Config::get('ldap.authentication.filter.query') . $username;
        $ldapversion = Config::get('ldap.version');

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
                    if ( ($userDn = @ldap_get_dn($connection, $entry)) !== false ) {
                        if( ($isBound = ldap_bind($connection, $userDn, $password)) == "true") {
                            return true;
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

            /**
             * =================================================================
             * Hack in LDAP authentication
             */

            // Try to get the user from the database.
            $user = (array) DB::table('users')->where('username', Input::get('username'))->first();

            if ($user && strpos($user["notes"],'LDAP') !== false) {
                LOG::debug("Authenticating user against LDAP.");
                if( $this->ldap(Input::get('username'), Input::get('password')) ) {
                        LOG::debug("valid login");
                    $pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
                    $user = Sentry::findUserByLogin( Input::get('username') );
                    $user->password = $pass;
                    $user->save();
                    $credentials = array(
                        'username' => Input::get('username'),
                        'password' => $pass,
                    );
                    Sentry::authenticate($credentials, Input::get('remember-me', 0));
                }
                else {
                    throw new Cartalyst\Sentry\Users\UserNotFoundException();
                }
            }
            /* ============================================================== */
            else {
                LOG::debug("Authenticating user against database.");
                // Try to log the user in
                Sentry::authenticate(Input::only('username', 'password'), Input::get('remember-me', 0));
            }

            // Get the page we were before
            $redirect = Session::get('loginRedirect', 'account');

            // Unset the page we were before from the session
            Session::forget('loginRedirect');

            // Redirect to the users page
            return Redirect::to($redirect)->with('success', Lang::get('auth/message.signin.success'));
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $this->messageBag->add('username', Lang::get('auth/message.account_not_found'));
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $this->messageBag->add('username', Lang::get('auth/message.account_not_activated'));
        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $this->messageBag->add('username', Lang::get('auth/message.account_suspended'));
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
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
