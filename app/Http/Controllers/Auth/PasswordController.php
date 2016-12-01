<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * This controller handles password resets for the user.
 * It uses the built-in Laravel magic of ResetsPasswords, so we
 * don't actually do much here.
 *
 * @author [A. Gianotto] [<snipe@snipe.net>]
 * @version    v1.0
 */
class PasswordController extends Controller
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
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     * Overriding method "getEmailSubject()" from trait "use ResetsPasswords"
     * @return string
     */
    public function getEmailSubject(){
        return property_exists($this, 'subject') ? $this->subject : \Lang::get('mail.reset_link');
    }

    /**
     * Get the response for after the reset link has been successfully sent.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        return redirect()->route('login')->with('status', trans($response));
    }
}
