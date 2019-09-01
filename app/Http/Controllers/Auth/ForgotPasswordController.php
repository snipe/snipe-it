<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
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
    public function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : \Lang::get('mail.reset_link');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['username' => 'required'], ['username.required' => 'Please enter your username.']);


        // Make sure the user is active, and their password is not controlled via LDAP
        $response = $this->broker()->sendResetLink(
            array_merge(
                $request->only('username'),
                ['activated' => '1'],
                ['ldap_import' => '0']
            )
        );

        if ($response === \Password::RESET_LINK_SENT) {
            \Log::info('Password reset attempt: User '.$request->input('username').' found, password reset sent');
        } else {
            \Log::info('Password reset attempt: User '.$request->input('username').' not found or user is inactive');
        }



        // Regardless of response, we do not want to disclose the status of a user account,
        // so we give them a generic "If this exists, we're TOTALLY gonna email you" response
        return redirect()->route('login')->with('success',trans('passwords.sent'));
    }
}
