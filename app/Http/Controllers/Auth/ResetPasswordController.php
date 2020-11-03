<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $username = 'username';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'username' => 'required',
            'password' => 'confirmed|'.Setting::passwordComplexityRulesSaving('store'),
        ];
    }


    protected function credentials(Request $request)
    {
        return $request->only(
            'username', 'password', 'password_confirmation', 'token'
        );
    }
    

    public function showResetForm(Request $request, $token = null)
    {
        \Log::debug(print_r($this->rules(),true));
        return view('auth.passwords.reset')->with(
            [
                'token' => $token,
                'username' => $request->input('username')
            ]
        );
    }


//    public function reset(Request $request)
//    {
//        $this->validate($request, $this->rules(), $this->validationErrorMessages());
//
//        // These two lines below allow you to bypass the default validation.
//        $broker = $this->broker();
//        $broker->validate(function () {
//            return true;
//        });
//
//        $response->reset(
//            $this->credentials($request), function ($user, $password) {
//                \Log::debug('resetting the password to '.$password);
//                $this->resetPassword($user, $password);
//            }
//        );
//
//        return $response == \Password::PASSWORD_RESET
//            ? $this->sendResetResponse($response)
//            : $this->sendResetFailedResponse($request, $response);
//    }


    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput(['username'=> $request->input('username')])
            ->withErrors(['username' => trans($response)]);
    }

}
