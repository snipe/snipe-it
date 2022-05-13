<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ldap;
use App\Models\Setting;
use Mail;
use App\Notifications\SlackTest;
use App\Notifications\MailTest;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 
use App\Http\Requests\SlackSettingsRequest;
use App\Http\Transformers\LoginAttemptsTransformer;


class SettingsController extends Controller
{


    public function ldaptest()
    {
        $settings = Setting::getSettings();

        if ($settings->ldap_enabled!='1') {
            \Log::debug('LDAP is not enabled cannot test.');
            return response()->json(['message' => 'LDAP is not enabled, cannot test.'], 400);
        }

        \Log::debug('Preparing to test LDAP connection');

        $message = []; //where we collect together test messages
        try {
            $connection = Ldap::connectToLdap();
            try {
                $message['bind'] = ['message' => 'Successfully bound to LDAP server.'];
                \Log::debug('attempting to bind to LDAP for LDAP test');
                Ldap::bindAdminToLdap($connection);
                $message['login'] = [
                    'message' => 'Successfully connected to LDAP server.',
                ];

                $users = collect(Ldap::findLdapUsers(null,10))->filter(function ($value, $key) {
                    return is_int($key);
                })->slice(0, 10)->map(function ($item) use ($settings) {
                    return (object) [
                        'username'        => $item[$settings['ldap_username_field']][0] ?? null,
                        'employee_number' => $item[$settings['ldap_emp_num']][0] ?? null,
                        'lastname'        => $item[$settings['ldap_lname_field']][0] ?? null,
                        'firstname'       => $item[$settings['ldap_fname_field']][0] ?? null,
                        'email'           => $item[$settings['ldap_email']][0] ?? null,
                    ];
                });
                if ($users->count() > 0) {
                    $message['user_sync'] = [
                        'users' => $users,
                    ];
                } else {
                    $message['user_sync'] = [
                        'message' => 'Connection to LDAP was successful, however there were no users returned from your query. You should confirm the Base Bind DN above.',
                    ];
    
                    return response()->json($message, 400);
                }

                return response()->json($message, 200);
            } catch (\Exception $e) {
                \Log::debug('Bind failed');
                \Log::debug("Exception was: ".$e->getMessage());
                return response()->json(['message' => $e->getMessage()], 400);
                //return response()->json(['message' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed but we cannot debug it any further on our end.');
            return response()->json(['message' => $e->getMessage()], 500);
        }


    }

    public function ldaptestlogin(Request $request)
    {

        if (Setting::getSettings()->ldap_enabled != '1') {
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

    public function slacktest(SlackSettingsRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'slack_endpoint'                      => 'url|required_with:slack_channel|starts_with:https://hooks.slack.com/|nullable',
            'slack_channel'                       => 'required_with:slack_endpoint|starts_with:#|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        // If validation passes, continue to the curl request
            $slack = new Client([
                'base_url' => e($request->input('slack_endpoint')),
                'defaults' => [
                    'exceptions' => false,
                ],
            ]);

            $payload = json_encode(
                [
                    'channel'    => e($request->input('slack_channel')),
                    'text'       => trans('general.slack_test_msg'),
                    'username'    => e($request->input('slack_botname')),
                    'icon_emoji' => ':heart:',
                ]);

            try {
                $slack->post($request->input('slack_endpoint'), ['body' => $payload]);
                return response()->json(['message' => 'Success'], 200);

            } catch (\Exception $e) {
                return response()->json(['message' => 'Please check the channel name and webhook endpoint URL ('.e($request->input('slack_endpoint')).'). Slack responded with: '.$e->getMessage()], 400);
            }

        //} 
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

            $file_parts = explode('.', $file);
            $extension = end($file_parts);
            \Log::debug($extension);

            // Only generated barcodes would have a .png file extension
            if ($extension == 'png') {
                \Log::debug('Deleting: '.$file);


                try {
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
        $allowed_columns = ['id', 'username', 'remote_ip', 'user_agent', 'successful', 'created_at'];

        $login_attempts = DB::table('login_attempts');
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'created_at';

        $total = $login_attempts->count();
        $login_attempts->orderBy($sort, $order);
        $login_attempt_results = $login_attempts->skip(request('offset', 0))->take(request('limit', 20))->get();

        return (new LoginAttemptsTransformer)->transformLoginAttempts($login_attempt_results, $total);
    }
}