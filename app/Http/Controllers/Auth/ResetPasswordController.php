<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\User;
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
            'password' => 'required|confirmed|min:6',
        ];
    }


    protected function credentials(Request $request)
    {
        return $request->only(
            'username', 'password', 'password_confirmation', 'token'
        );
    }
    

    public function showSnipeResetForm(Request $request, $token = null)
    {
        // Check that the user is active
        if ($user = User::where('username', '=',$request->input('username'))->where('activated','=','1')->count() > 0) {
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'username' => $request->username]
            );

        }
        return redirect()->route('password.request')->withErrors(['username' => 'No matching users']);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => trans($response)]);
    }

}
