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
use PragmaRX\Google2FA\Google2FA;

/**
 * This controller handles authentication for the user, including local
 * database users and LDAP users.
 *
 * @author [A. Gianotto] [<snipe@snipe.net>]
 * @version    v1.0
 */
class LoginController extends Controller
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
        $this->middleware('guest', ['except' => ['logout','postTwoFactorAuth','getTwoFactorAuth','getTwoFactorEnroll']]);
        \Session::put('backUrl', \URL::previous());
    }

    function showLoginForm(Request $request)
    {
        $this->loginViaRemoteUser($request);
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }

        if (Setting::getSettings()->login_common_disabled == "1") {
            return view('errors.403');
        }

        return view('auth.login');
    }

    private function loginViaRemoteUser(Request $request)
    {
        $remote_user = $request->server('REMOTE_USER');
        if (Setting::getSettings()->login_remote_user_enabled == "1" && isset($remote_user) && !empty($remote_user)) {
            Log::debug("Authenticatiing via REMOTE_USER.");

            $pos = strpos($remote_user, '\\');
            if ($pos > 0) {
                $remote_user = substr($remote_user, $pos + 1);
            };
            
            try {
                $user = User::where('username', '=', $remote_user)->whereNull('deleted_at')->where('activated', '=', '1')->first();
                Log::debug("Remote user auth lookup complete");
                if(!is_null($user)) Auth::login($user, true);
            } catch(Exception $e) {
                Log::error("There was an error authenticating the Remote user: " . $e->getMessage());
            }
        }
    }

    private function loginViaLdap(Request $request)
    {
        Log::debug("Binding user to LDAP.");
        $ldap_user = Ldap::findAndBindUserLdap($request->input('username'), $request->input('password'));
        if (!$ldap_user) {
            Log::debug("LDAP user ".$request->input('username')." not found in LDAP or could not bind");
            throw new \Exception("Could not find user in LDAP directory");
        } else {
            Log::debug("LDAP user ".$request->input('username')." successfully bound to LDAP");
        }

        // Check if the user already exists in the database and was imported via LDAP
        $user = User::where('username', '=', Input::get('username'))->whereNull('deleted_at')->where('ldap_import', '=', 1)->where('activated', '=', '1')->first();
        Log::debug("Local auth lookup complete");

        // The user does not exist in the database. Try to get them from LDAP.
        // If user does not exist and authenticates successfully with LDAP we
        // will create it on the fly and sign in with default permissions
        if (!$user) {
            Log::debug("Local user ".Input::get('username')." does not exist");
            Log::debug("Creating local user ".Input::get('username'));

            if ($user = Ldap::createUserFromLdap($ldap_user)) { //this handles passwords on its own
                Log::debug("Local user created.");
            } else {
                Log::debug("Could not create local user.");
                throw new \Exception("Could not create local user");
            }
            // If the user exists and they were imported from LDAP already
        } else {
            Log::debug("Local user ".$request->input('username')." exists in database. Updating existing user against LDAP.");

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
        if (Setting::getSettings()->login_common_disabled == "1") {
            return view('errors.403');
        }

        $validator = $this->validator(Input::all());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $this->maxLoginAttempts = config('auth.throttle.max_attempts');
        $this->lockoutTime = config('auth.throttle.lockout_duration');

        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $user = null;

        // Should we even check for LDAP users?
        if (Setting::getSettings()->ldap_enabled=='1') {
            Log::debug("LDAP is enabled.");
            try {
                $user = $this->loginViaLdap($request);
                Auth::login($user, true);

            // If the user was unable to login via LDAP, log the error and let them fall through to
            // local authentication.
            } catch (\Exception $e) {
                Log::error("There was an error authenticating the LDAP user: ".$e->getMessage());
            }
        }

        // If the user wasn't authenticated via LDAP, skip to local auth
        if (!$user) {
            Log::debug("Authenticating user against database.");
          // Try to log the user in
            if (!Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password'), 'activated' => 1], $request->input('remember'))) {

                if (!$lockedOut) {
                    $this->incrementLoginAttempts($request);
                }

                Log::debug("Local authentication failed.");
                return redirect()->back()->withInput()->with('error', trans('auth/message.account_not_found'));
            } else {

                  $this->clearLoginAttempts($request);
            }
        }

        if ($user = Auth::user()) {
            $user->last_login = \Carbon::now();
            \Log::debug('Last login:'.$user->last_login);
            $user->save();
        }
        // Redirect to the users page
        return redirect()->intended()->with('success', trans('auth/message.signin.success'));
    }


    /**
     * Two factor enrollment page
     *
     * @return Redirect
     */
    public function getTwoFactorEnroll()
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $user = Auth::user();
        $google2fa = app()->make('PragmaRX\Google2FA\Contracts\Google2FA');

        if ($user->two_factor_secret=='') {
            $user->two_factor_secret = $google2fa->generateSecretKey(32);
            $user->save();
        }


        $google2fa_url = $google2fa->getQRCodeGoogleUrl(
            urlencode(Setting::getSettings()->site_name),
            urlencode($user->username),
            $user->two_factor_secret
        );

        return view('auth.two_factor_enroll')->with('google2fa_url', $google2fa_url);

    }


    /**
     * Two factor code form page
     *
     * @return Redirect
     */
    public function getTwoFactorAuth()
    {
        return view('auth.two_factor');
    }

    /**
     * Two factor code submission
     *
     * @return Redirect
     */
    public function postTwoFactorAuth(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $user = Auth::user();
        $secret = $request->get('two_factor_secret');
        $google2fa = app()->make('PragmaRX\Google2FA\Contracts\Google2FA');
        $valid = $google2fa->verifyKey($user->two_factor_secret, $secret);

        if ($valid) {
            $user->two_factor_enrolled = 1;
            $user->save();
            $request->session()->put('2fa_authed', 'true');
            return redirect()->route('home')->with('success', 'You are logged in!');
        }

        return redirect()->route('two-factor')->with('error', 'Invalid two-factor code');


    }


    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function logout(Request $request)
    {
        $request->session()->forget('2fa_authed');

        Auth::logout();

        $settings = Setting::getSettings();
        $customLogoutUrl = $settings->login_remote_user_custom_logout_url ;
        if ($settings->login_remote_user_enabled == '1' && $customLogoutUrl != '') {
            return redirect()->away($customLogoutUrl);
        }

        return redirect()->route('login')->with('success', 'You have successfully logged out!');
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


    public function username()
    {
        return 'username';
    }

    /**
    * Redirect the user after determining they are locked out.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $minutes = round($seconds / 60);

        $message = \Lang::get('auth/message.throttle', ['minutes' => $minutes]);

            return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([$this->username() => $message]);
    }


    /**
    * Override the lockout time and duration
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        $lockoutTime = config('auth.throttle.lockout_duration');
        $maxLoginAttempts = config('auth.throttle.max_attempts');

        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            $maxLoginAttempts,
            $lockoutTime
        );
    }

    public function legacyAuthRedirect() {
        return redirect()->route('login');
    }

    public function redirectTo()
    {
        return Session::get('backUrl') ? Session::get('backUrl') :   $this->redirectTo;
    }

}
