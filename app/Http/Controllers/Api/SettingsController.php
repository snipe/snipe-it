<?php

namespace App\Http\Controllers\Api;

use DB;
use Mail;
use Validator;
use Notification;
use App\Models\Ldap;
use App\Models\LdapAd;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Notifications\MailTest;
use App\Notifications\SlackTest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Transformers\LoginAttemptsTransformer;

class SettingsController extends Controller
{

    /**
     * Test the ldap settings
     * 
     * @author Wes Hulette <jwhulette@gmail.com>
     * 
     * @since 5.0.0
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function ldapAdSettingsTest(): JsonResponse
    {   
        $ldap = new LdapAd();

        if($ldap->ldapSettings['ldap_enabled'] === false) {
            Log::info('LDAP is not enabled cannot test.');
            return response()->json(['message' => 'LDAP is not enabled, cannot test.'], 400);
        }

        // The connect, bind and resulting users message
        $message = [];

        Log::info('Preparing to test LDAP user login');
        // Test user can connect to the LDAP server
        try {
            $ldap->testLdapAdUserConnection();
            $message['login'] = [
                'message' => 'Successfully connected to LDAP server.'
            ];
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Error logging into LDAP server, error: ' . $ex->getMessage() . ' - Verify your that your username and password are correct'
            ], 400);
        }

        Log::info('Preparing to test LDAP bind connection');
        // Test user can bind to the LDAP server
        try {
            $ldap->testLdapAdBindConnection();
            $message['bind'] = [
                'message' => 'Successfully binded to LDAP server.'
            ];
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Error binding to LDAP server, error: ' . $ex->getMessage()
            ], 400);
        }

        Log::info('Preparing to get sample user set from LDAP directory');
        // Get a sample of 10 users so user can verify the data is correct
        try {
            $users = $ldap->testUserImportSync();
            $message['user_sync']  = [
                'users' => $users
            ];
        } catch (\Exception $ex) {
            $message['user_sync']  = [
                'message' => 'Error getting users from LDAP directory, error: ' . $ex->getMessage()
            ];
            return response()->json($message, 400);
        }

        return response()->json($message, 200);
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

    /**
     * Get a list of login attempts
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.0.0]
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function showLoginAttempts(Request $request)
    {
        $allowed_columns = ['id', 'username', 'remote_ip', 'user_agent','successful','created_at'];

        $login_attempts =  DB::table('login_attempts');
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';

        $total = $login_attempts->count();
        $login_attempts->orderBy($sort, $order);
        $login_attempt_results = $login_attempts->skip(request('offset', 0))->take(request('limit',  20))->get();

        return (new LoginAttemptsTransformer)->transformLoginAttempts($login_attempt_results, $total);

    }



}
