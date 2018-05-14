<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ldap;
use Validator;
use App\Models\Setting;
use Mail;
use App\Notifications\SlackTest;
use Notification;
use App\Notifications\MailTest;

class SettingsController extends Controller
{


    public function ldaptest()
    {

        if (Setting::getSettings()->ldap_enabled!='1') {
            \Log::debug('LDAP is not enabled cannot test.');
            return response()->json(['message' => 'LDAP is not enabled, cannot test.'], 400);
        }

        \Log::debug('Preparing to test LDAP connection');

        try {
            $connection = Ldap::connectToLdap();
            try {
                \Log::debug('attempting to bind to LDAP for LDAP test');
                Ldap::bindAdminToLdap($connection);
                return response()->json(['message' => 'It worked!'], 200);
            } catch (\Exception $e) {
                \Log::debug('Bind failed');
                return response()->json(['message' => $e->getMessage()], 400);
                //return response()->json(['message' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed');
            return response()->json(['message' => $e->getMessage()], 600);
        }


    }

    public function ldaptestlogin(Request $request)
    {

        if (Setting::getSettings()->ldap_enabled!='1') {
            \Log::debug('LDAP is not enabled. Cannot test.');
            return response()->json(['message' => 'LDAP is not enabled, cannot test.'], 400);
        }


        $rules = array(
            'ldaptest_user' => 'required',
            'ldaptest_password' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            \Log::debug('LDAP Validation test failed.');
            $validation_errors = implode(' ',$validator->errors()->all());
            return response()->json(['message' => $validator->errors()->all()], 400);
        }
        

        \Log::debug('Preparing to test LDAP login');
        try {
            $connection = Ldap::connectToLdap();
            try {
                Ldap::bindAdminToLdap($connection);
                \Log::debug('Attempting to bind to LDAP for LDAP test');
                try {
                    $ldap_user = Ldap::findAndBindUserLdap($request->input('ldaptest_user'), $request->input('ldaptest_password'));
                    if ($ldap_user) {
                        \Log::debug('It worked! '. $request->input('ldaptest_user').' successfully binded to LDAP.');
                        return response()->json(['message' => 'It worked! '. $request->input('ldaptest_user').' successfully binded to LDAP.'], 200);
                    }
                    return response()->json(['message' => 'Login Failed. '. $request->input('ldaptest_user').' did not successfully bind to LDAP.'], 400);

                } catch (\Exception $e) {
                    \Log::debug('LDAP login failed');
                    return response()->json(['message' => $e->getMessage()], 400);
                }

            } catch (\Exception $e) {
                \Log::debug('Bind failed');
                return response()->json(['message' => $e->getMessage()], 400);
                //return response()->json(['message' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed');
            return response()->json(['message' => $e->getMessage()], 500);
        }


    }


    public function slacktest()
    {

        if ($settings = Setting::getSettings()->slack_channel=='') {
            \Log::debug('Slack is not enabled. Cannot test.');
            return response()->json(['message' => 'Slack is not enabled, cannot test.'], 400);
        }

        \Log::debug('Preparing to test slack connection');

        try {
            Notification::send($settings = Setting::getSettings(), new SlackTest());
            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $e) {
            \Log::debug('Slack connection failed');
            return response()->json(['message' => $e->getMessage()], 400);
        }


    }


    /**
     * Test the email configuration
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return Redirect
     */
    public function ajaxTestEmail()
    {
        if (!config('app.lock_passwords')) {
            try {
                Notification::send(Setting::first(), new MailTest());
                return response()->json(['message' => 'Mail sent to '.config('mail.reply_to.address')], 200);
            } catch (Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        return response()->json(['message' => 'Mail would have been sent, but this application is in demo mode! '], 200);

    }



}
