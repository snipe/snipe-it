<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\LoginAttemptsTransformer;
use App\Models\Setting;
use App\Notifications\MailTest;
use App\Services\LdapAd;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    /**
     * Test the ldap settings
     * 
     * @author Wes Hulette <jwhulette@gmail.com>
     * 
     * @since 5.0.0
     * 
     * @param App\Models\LdapAd $ldap
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function ldapAdSettingsTest(LdapAd $ldap): JsonResponse
    {
        if(!$ldap->init()) {
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
                \Log::debug('LDAP connected but Bind failed. Please check your LDAP settings and try again.');
            return response()->json([
                'message' => 'Error logging into LDAP server, error: ' . $ex->getMessage() . ' - Verify your that your username and password are correct']);

        } catch (\Exception $e) {
            \Log::info('LDAP connection failed but we cannot debug it any further on our end.');
            return response()->json(['message' => 'The LDAP connection failed but we cannot debug it any further on our end. The error from the server is: '.$e->getMessage()], 500);
        }

        Log::info('Preparing to test LDAP bind connection');
        // Test user can bind to the LDAP server
        try {
            Log::info('Testing Bind');
            $ldap->testLdapAdBindConnection();
            $message['bind'] = [
                'message' => 'Successfully binded to LDAP server.'
            ];
        } catch (\Exception $ex) {
            Log::info('LDAP Bind failed');
            return response()->json([
                'message' => 'Error binding to LDAP server, error: ' . $ex->getMessage()
            ], 400);
        }


        Log::info('Preparing to get sample user set from LDAP directory');
        // Get a sample of 10 users so user can verify the data is correct
        try {
            Log::info('Testing LDAP sync');
            error_reporting(E_ALL & ~E_DEPRECATED); // workaround for php7.4, which deprecates ldap_control_paged_result
            $users = $ldap->testUserImportSync();
            $message['user_sync']  = [
                'users' => $users
            ];
        } catch (\Exception $ex) {
            Log::info('LDAP sync failed');
            $message['user_sync']  = [
                'message' => 'Error getting users from LDAP directory, error: ' . $ex->getMessage()
            ];
            return response()->json($message, 400);
        }

        return response()->json($message, 200);
    }

    public function ldaptestlogin(Request $request, LdapAd $ldap)
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
            DB::beginTransaction(); //this was the easiest way to invoke a full test of an LDAP login without adding new users to the DB (which may not be desired)

            // $results = $ldap->ldap->auth()->attempt($request->input('ldaptest_username'), $request->input('ldaptest_password'), true);
            // can't do this because that's a protected property.

            $results = $ldap->ldapLogin($request->input('ldaptest_user'), $request->input('ldaptest_password')); // this would normally create a user on success (if they didn't already exist), but for the transaction
            if($results) {
                return response()->json(['message' => 'It worked! '. $request->input('ldaptest_user').' successfully binded to LDAP.'], 200);
            } else {
                return response()->json(['message' => 'Login Failed. '. $request->input('ldaptest_user').' did not successfully bind to LDAP.'], 400);
            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed');
            return response()->json(['message' => $e->getMessage()], 400);
        } finally {
            DB::rollBack(); // ALWAYS rollback, whether success or failure
        }


    }

    public function slacktest(Request $request)
    {

        $slack = new Client([
            'base_url' => e($request->input('slack_endpoint')),
            'defaults' => [
                'exceptions' => false
            ]
        ]);


        $payload = json_encode(
            [
                'channel'    => e($request->input('slack_channel')),
                'text'       => trans('general.slack_test_msg'),
                'username'    => e($request->input('slack_botname')),
                'icon_emoji' => ':heart:'
            ]);

        try {
            $slack->post($request->input('slack_endpoint'),['body' => $payload]);
            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops! Please check the channel name and webhook endpoint URL. Slack responded with: '.$e->getMessage()], 400);
        }

        return response()->json(['message' => 'Something went wrong :( '], 400);

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
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        return response()->json(['message' => 'Mail would have been sent, but this application is in demo mode! '], 200);

    }


    /**
     * Delete server-cached barcodes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.0.0]
     * @return Response
     */
    public function purgeBarcodes()
    {

        $file_count = 0;
        $files = Storage::disk('public')->files('barcodes');

        foreach ($files as $file) { // iterate files

            $file_parts = explode(".", $file);
            $extension = end($file_parts);
            \Log::debug($extension);

            // Only generated barcodes would have a .png file extension
            if ($extension =='png') {

                \Log::debug('Deleting: '.$file);


                try  {
                    Storage::disk('public')->delete($file);
                    \Log::debug('Deleting: '.$file);
                    $file_count++;
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            }

        }

        return response()->json(['message' => 'Deleted '.$file_count.' barcodes'], 200);

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
