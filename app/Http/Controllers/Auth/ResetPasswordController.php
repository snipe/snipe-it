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
    

    public function showSnipeResetForm(Request $request, $token = null)
    {
        // Check that the user is active
        if ($user = User::where('email', '=',$request->input('email'))->where('activated','=','1')->count() > 0) {
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email]
            );

        }
        return redirect()->route('password.request')->withErrors(['email' => 'No matching users']);
    }

}
