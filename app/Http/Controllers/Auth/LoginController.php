<?php

namespace App\Http\Controllers\Auth;

use App\Services\LdapAd;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Illuminate\Support\Facades\Log;

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
     * @var LdapAd
     */
    protected $ldap;

    /**
     * Create a new authentication controller instance.
     *
     * @param LdapAd $ldap
     *
     * @return void
     */
    public function __construct(LdapAd $ldap)
    {
        parent::__construct();
        $this->middleware('guest', ['except' => ['logout','postTwoFactorAuth','getTwoFactorAuth','getTwoFactorEnroll']]);
        Session::put('backUrl', \URL::previous());
        $this->ldap = $ldap;
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

    /**
     * Log in a user by LDAP
     * 
     * @author Wes Hulette <jwhulette@gmail.com>
     * 
     * @since 5.0.0
     *
     * @param Request $request
     * 
     * @return User
     * 
     * @throws \Exception
     */
    private function loginViaLdap(Request $request): User
    {
        try {
            return $this->ldap->ldapLogin($request->input('username'), $request->input('password'));
        } catch (\Exception $ex) {
            LOG::debug("LDAP user login: " . $ex->getMessage());
            throw new \Exception($ex->getMessage());
        }
    }

    private function loginViaRemoteUser(Request $request)
    {
        $remote_user = $request->server('REMOTE_USER');
        if (Setting::getSettings()->login_remote_user_enabled == "1" && isset($remote_user) && !empty($remote_user)) {
            LOG::debug("Authenticatiing via REMOTE_USER.");

            $pos = strpos($remote_user, '\\');
            if ($pos > 0) {
                $remote_user = substr($remote_user, $pos + 1);
            };
            
            try {
                $user = User::where('username', '=', $remote_user)->whereNull('deleted_at')->where('activated', '=', '1')->first();
                LOG::debug("Remote user auth lookup complete");
                if(!is_null($user)) Auth::login($user, true);
            } catch(Exception $e) {
                LOG::error("There was an error authenticating the Remote user: " . $e->getMessage());
            }
        }
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
        if ($this->ldap->init()) {
            LOG::debug("LDAP is enabled.");
            try {
                LOG::debug("Attempting to log user in by LDAP authentication.");
                $user = $this->loginViaLdap($request);
                Auth::login($user, true);

            // If the user was unable to login via LDAP, log the error and let them fall through to
            // local authentication.
            } catch (\Exception $e) {
                LOG::error("There was an error authenticating the LDAP user: ".$e->getMessage());
            }
        }

        // If the user wasn't authenticated via LDAP, skip to local auth
        if (!$user) {
            LOG::debug("Authenticating user against database.");
          // Try to log the user in
            if (!Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password'), 'activated' => 1], $request->input('remember'))) {

                if (!$lockedOut) {
                    $this->incrementLoginAttempts($request);
                }

                LOG::debug("Local authentication failed.");
                return redirect()->back()->withInput()->with('error', trans('auth/message.account_not_found'));
            } else {

                  $this->clearLoginAttempts($request);
            }
        }

        if ($user = Auth::user()) {
            $user->last_login = Carbon::now();
            Log::debug('Last login:'.$user->last_login);
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
        $google2fa = app()->make('pragmarx.google2fa');

        if ($user->two_factor_secret=='') {
            $user->two_factor_secret = $google2fa->generateSecretKey(32);
            $user->save();
        }


        $google2fa_url = $google2fa->getQRCodeInline(
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
     * @param Request $request
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
        $google2fa = app()->make('pragmarx.google2fa');
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
     * @param Request $request
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
    * @return  bool
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
