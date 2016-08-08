<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\Setting;
use App\Models\Ldap;
use App\Models\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Log;
use View;



/**
 * This controller handles authentication for the user, including local
 * database users and LDAP users.
 *
 * @todo Move LDAP methods into user model for better separation of concerns.
 * @author [A. Gianotto] [<snipe@snipe.net>]
 * @version    v1.0
 */
class AuthController extends Controller
{

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
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function login(Request $request)
    {
        $validator = $this->validator(Input::all());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Should we even check for LDAP users?
        if (Setting::getSettings()->ldap_enabled=='1') {

            LOG::debug("LDAP is enabled.");
            // Check if the user exists in the database
            $user = User::where('username', '=', Input::get('username'))->whereNull('deleted_at')->first();
            LOG::debug("Local auth lookup complete");

            try {
                Ldap::findAndBindUserLdap($request->input('username'), $request->input('password'));
                LOG::debug("Binding user to LDAP.");
            } catch (\Exception $e) {
                LOG::debug("User ".Input::get('username').' did not authenticate successfully against LDAP.');
                //$ldap_error = $e->getMessage();
                // return redirect()->back()->withInput()->with('error',$e->getMessage());
            }


            // The user does not exist in the database. Try to get them from LDAP.
            // If user does not exist and authenticates sucessfully with LDAP we
            // will create it on the fly and sign in with default permissions
            if (!$user) {
                LOG::debug("Local user ".Input::get('username')." does not exist");

                try {

                    if ($userattr = Ldap::findAndBindUserLdap($request->input('username'), $request->input('password'))) {
                        LOG::debug("Creating local user ".Input::get('username'));

                        if ($newuser = Ldap::createUserFromLdap($userattr)) {
                            LOG::debug("Local user created.");
                        } else {
                            LOG::debug("Could not create local user.");
                        }

                    } else {
                        LOG::debug("User did not authenticate correctly against LDAP. No local user was created.");
                    }

                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->with('error',$e->getMessage());
                }

            // If the user exists and they were imported from LDAP already
            } else {

                LOG::debug("Local user ".Input::get('username')." exists in database. Authenticating existing user against LDAP.");

                if ($ldap_user = Ldap::findAndBindUserLdap($request->input('username'), $request->input('password'))) {
                    $ldap_attr = Ldap::parseAndMapLdapAttributes($ldap_user);

                    LOG::debug("Valid LDAP login. Updating the local data.");

                    if (Setting::getSettings()->ldap_pw_sync=='1') {
                        $user->password = bcrypt($request->input('password'));
                    }

                    $user->email = $ldap_attr['email'];
                    $user->first_name = $ldap_attr['firstname'];
                    $user->last_name = $ldap_attr['lastname'];
                    $user->save();

                    if (Setting::getSettings()->ldap_pw_sync!='1') {
                        Auth::login($user, true);
                        // Redirect to the users page
                        return redirect()->to('/home')->with('success', trans('auth/message.signin.success'));
                    }

                } else {
                    LOG::debug("User ".Input::get('username')." did not authenticate correctly against LDAP. Local user was not updated.");
                }// End LDAP auth

            } // End if(!user)

        // NO LDAP enabled - just try to login the user normally
        }


        LOG::debug("Authenticating user against database.");
        // Try to log the user in
        if (!Auth::attempt(Input::only('username', 'password'), Input::get('remember-me', 0))) {
            LOG::debug("Local authentication failed.");
            // throw new Cartalyst\Sentry\Users\UserNotFoundException();
            return redirect()->back()->withInput()->with('error', trans('auth/message.account_not_found'));
        }



        // Get the page we were before
        $redirect = \Session::get('loginRedirect', 'home');

        // Unset the page we were before from the session
        \Session::forget('loginRedirect');

        // Redirect to the users page
        return redirect()->to($redirect)->with('success', trans('auth/message.signin.success'));

        // Ooops.. something went wrong
        return redirect()->back()->withInput()->withErrors($this->messageBag);
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
        return redirect()->route('home')->with('success', 'You have successfully logged out!');
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
