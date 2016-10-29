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

    private function login_via_ldap(Request $request)
    {
        LOG::debug("Binding user to LDAP.");
        $ldap_user = Ldap::findAndBindUserLdap($request->input('username'), $request->input('password'));
        if(!$ldap_user) {
          throw new Exception("Could not find user in LDAP directory");
        }

        // Check if the user exists in the database
        $user = User::where('username', '=', Input::get('username'))->whereNull('deleted_at')->first();
        LOG::debug("Local auth lookup complete");

        // The user does not exist in the database. Try to get them from LDAP.
        // If user does not exist and authenticates sucessfully with LDAP we
        // will create it on the fly and sign in with default permissions
        if (!$user) {
            LOG::debug("Local user ".Input::get('username')." does not exist");
            LOG::debug("Creating local user ".Input::get('username'));

            if ($newuser = Ldap::createUserFromLdap($userattr)) { //this handles passwords on its own
                LOG::debug("Local user created.");
            } else {
                LOG::debug("Could not create local user.");
                throw new Exception("Could not create local user");
            }
            // If the user exists and they were imported from LDAP already
        } else {
            LOG::debug("Local user ".Input::get('username')." exists in database. Updating existing user against LDAP.");

            $ldap_attr = Ldap::parseAndMapLdapAttributes($ldap_user);

            if (Setting::getSettings()->ldap_pw_sync=='1') {
                $user->password = bcrypt($request->input('password'));
            }

            $user->email = $ldap_attr['email'];
            $user->first_name = $ldap_attr['firstname'];
            $user->last_name = $ldap_attr['lastname'];
            $user->save();
        } // End if(!user)
        return $user;
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
        $user = null;
        // Should we even check for LDAP users?
        if (Setting::getSettings()->ldap_enabled=='1') {
            LOG::debug("LDAP is enabled.");
            try {
              $user=$this->login_via_ldap($request);
              Auth::login($user, true);
            } catch (Exception $e) {
              if(Setting::getSettings()->ldap_pw_sync!='1') {
                return redirect()->back()->withInput()->with('error',$e->getMessage());
              }
            }
        }
        if(!$user) {
          LOG::debug("Authenticating user against database.");
          // Try to log the user in
          if (!Auth::attempt(Input::only('username', 'password'), Input::get('remember-me', 0))) {
              LOG::debug("Local authentication failed.");
              // throw new Cartalyst\Sentry\Users\UserNotFoundException();
              return redirect()->back()->withInput()->with('error', trans('auth/message.account_not_found'));
          }
        }

        // Get the page we were before
        $redirect = \Session::get('loginRedirect', 'home');

        // Unset the page we were before from the session
        \Session::forget('loginRedirect');

        // Redirect to the users page
        return redirect()->to($redirect)->with('success', trans('auth/message.signin.success'));
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
