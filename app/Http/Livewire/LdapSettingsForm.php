<?php

namespace App\Http\Livewire;

use App\Models\Ldap;
use App\Models\Setting;
use App\Models\Group;
use Livewire\Component;

class LdapSettingsForm extends Component
{
      public bool   $ldap_enabled;
      public        $ldap_server;
      public bool   $ldap_server_cert_ignore;
      public        $ldap_uname;
      public        $ldap_pword;
      public        $ldap_basedn;
      public        $ldap_filter;
      public        $ldap_username_field;
      public        $ldap_lname_field;
      public        $ldap_fname_field;
      public        $ldap_auth_filter_query;
      public        $ldap_version;
      public        $ldap_active_flag;
      public        $ldap_emp_num;
      public        $ldap_email;
      public        $ldap_manager;
      public        $ad_domain;
      public bool   $is_ad;
      public bool   $ldap_tls;
      public bool   $ldap_pw_sync;
//    public        $custom_forgot_pass_url,
      public        $ldap_jobtitle;
      public        $ldap_country;
      public        $ldap_dept;
      public        $ldap_client_tls_cert;
      public        $ldap_client_tls_key;
      public        $ldap_default_group;
      public        $ldap_phone_field;
      public        $groups;
      public        $ldaptest_user;
      public        $ldaptest_password;

      protected $rules = [
          'ldap_username_field' => 'not_in:sAMAccountName',
          'ldap_auth_filter_query' => 'not_in:uid=samaccountname|required_if:ldap_enabled,1',
          'ldap_filter' => 'nullable|regex:"^[^(]"|required_if:ldap_enabled,1',
      ];
      protected  array $messages = [
              'ldap_username_field.not_in' => '<code>sAMAccountName</code> (mixed case) will likely not work. You should use <code>samaccountname</code> (lowercase) instead. ',
              'ldap_auth_filter_query.not_in' => '<code>uid=samaccountname</code> is probably not a valid auth filter. You probably want <code>uid=</code> ',
              'ldap_filter.regex' => 'This value should probably not be wrapped in parentheses.',
          ];



    public Setting $setting;

    public function mount(){

        $this->setting = Setting::getSettings();
        $this->groups = Group::all();

        $this->ldap_enabled              = $this->setting->ldap_enabled;
        $this->ldap_server               = $this->setting->ldap_server;
        $this->ldap_server_cert_ignore   = $this->setting->ldap_server_cert_ignore;
        $this->ldap_uname                = $this->setting->ldap_uname;
        $this->ldap_pword                = $this->setting->ldap_pword;
        $this->ldap_basedn               = $this->setting->ldap_basedn;
        $this->ldap_default_group        = $this->setting->ldap_default_group;
        $this->ldap_filter               = $this->setting->ldap_filter;
        $this->ldap_username_field       = $this->setting->ldap_username_field;
        $this->ldap_lname_field          = $this->setting->ldap_lname_field;
        $this->ldap_fname_field          = $this->setting->ldap_fname_field;
        $this->ldap_auth_filter_query    = $this->setting->ldap_auth_filter_query;
        $this->ldap_version              = $this->setting->ldap_version;
        $this->ldap_active_flag          = $this->setting->ldap_active_flag;
        $this->ldap_emp_num              = $this->setting->ldap_emp_num;
        $this->ldap_email                = $this->setting->ldap_email;
        $this->ldap_manager              = $this->setting->ldap_manager;
        $this->ad_domain                 = $this->setting->ad_domain;
        $this->is_ad                     = $this->setting->is_ad;
        $this->ad_append_domain          = $this->setting->ad_append_domain;
        $this->ldap_tls                  = $this->setting->ldap_tls;
        $this->ldap_pw_sync              = $this->setting->ldap_pw_sync;
        $this->custom_forgot_pass_url    = $this->setting->custom_forgot_pass_url;
        $this->ldap_phone_field          = $this->setting->ldap_phone_field;
        $this->ldap_jobtitle             = $this->setting->ldap_jobtitle;
        $this->ldap_country              = $this->setting->ldap_country;
        $this->ldap_dept                 = $this->setting->ldap_dept;
        $this->ldap_client_tls_cert      = $this->setting->ldap_client_tls_cert;
        $this->ldap_client_tls_key       = $this->setting->ldap_client_tls_key;

    }

    public function render()
    {
        return view('livewire.ldap-settings-form');
    }


    public function submit(){

//        $this->validate($this->rules,$this->messages, $field );

        $this->setting->ldap_enabled              = $this->ldap_enabled;
        $this->setting->ldap_server               = $this->ldap_server;
        $this->setting->ldap_server_cert_ignore   = $this->ldap_server_cert_ignore;
        $this->setting->ldap_uname                = $this->ldap_uname;
        $this->setting->ldap_pword                = $this->ldap_pword;
        $this->setting->ldap_basedn               = $this->ldap_basedn;
        $this->setting->ldap_default_group        = $this->ldap_default_group;
        $this->setting->ldap_filter               = $this->ldap_filter;
        $this->setting->ldap_username_field       = $this->ldap_username_field;
        $this->setting->ldap_lname_field          = $this->ldap_lname_field;
        $this->setting->ldap_fname_field          = $this->ldap_fname_field;
        $this->setting->ldap_auth_filter_query    = $this->ldap_auth_filter_query;
        $this->setting->ldap_version              = $this->ldap_version;
        $this->setting->ldap_active_flag          = $this->ldap_active_flag;
        $this->setting->ldap_emp_num              = $this->ldap_emp_num;
        $this->setting->ldap_email                = $this->ldap_email;
        $this->setting->ldap_manager              = $this->ldap_manager;
        $this->setting->ad_domain                 = $this->ad_domain;
        $this->setting->is_ad                     = $this->is_ad;
        $this->setting->ad_append_domain          = $this->ad_append_domain;
        $this->setting->ldap_tls                  = $this->ldap_tls;
        $this->setting->ldap_pw_sync              = $this->ldap_pw_sync;
        $this->setting->custom_forgot_pass_url    = $this->custom_forgot_pass_url;
        $this->setting->ldap_phone_field          = $this->ldap_phone_field;
        $this->setting->ldap_jobtitle             = $this->ldap_jobtitle;
        $this->setting->ldap_country              = $this->ldap_country;
        $this->setting->ldap_dept                 = $this->ldap_dept;
        $this->setting->ldap_client_tls_cert      = $this->ldap_client_tls_cert;
        $this->setting->ldap_client_tls_key       = $this->ldap_client_tls_key;

        $this->setting->save();
    }
    public function ldapsynctest()
    {

        $this->ldapad_test_results = '<i class="fas fa-spinner spin"></i> ' . trans('admin/settings/message.ldap.testing');
        $response = $this->ldaptest();


//        if ($response->successful()) {
//            $this->ldapad_test_results = $this->buildLdapTestResults($response->json());
//        } else {
//            $this->ldapad_test_results = '<i class="fas fa-exclamation-triangle text-danger"></i> ';
//            if ($response->status() === 500) {
//                $this->ldapad_test_results .= trans('admin/settings/message.ldap.500');
//            } elseif ($response->status() === 400) {
//                $errorMessage = '';
//                if (isset($response->json()['user_sync'])) {
//                    $errorMessage = $response->json()['user_sync']['message'];
//                }
//                if (isset($response->json()['message'])) {
//                    $errorMessage = $response->json()['message'];
//                }
//                $this->ldapad_test_results .= $errorMessage;
//            } else {
//                $this->ldapad_test_results .= trans('admin/settings/message.ldap.error');
//            }
//        }
    }
    public function buildLdapTestResults($results)
    {
        $html = '<ul style="list-style: none;padding-left: 5px;">';
        $html .= '<li class="text-success"><i class="fas fa-check" aria-hidden="true"></i> ' . $results['login']['message'] . ' </li>';
        $html .= '<li class="text-success"><i class="fas fa-check" aria-hidden="true"></i> ' . $results['bind']['message'] . ' </li>';
        $html .= '</ul>';
        $html .= '<div>{{ trans("admin/settings/message.ldap.sync_success") }}</div>';
        $html .= '<table class="table table-bordered table-condensed" style="background-color: #fff">';
        $html .= $this->buildLdapResultsTableHeader();
        $html .= $this->buildLdapResultsTableBody($results['user_sync']['users']);
        $html .= '</table>';
        return $html;
    }

    public function buildLdapResultsTableHeader()
    {
        // Build the HTML table header
        $this->keys = [
            trans('admin/settings/general.employee_number'),
            trans('mail.username'),
            trans('general.first_name'),
            trans('general.last_name'),
            trans('general.email'),
        ];
        $header = '<thead><tr>';
        foreach ( $this->keys as $key) {
            $header .= '<th>' . $key . '</th>';
        }

        $header .= "</tr></thead>";

        return $header;
    }

    public function buildLdapResultsTableBody($users)
    {
        // Build the HTML table body
        $body = '<tbody>';
        foreach ($users as $user) {
            $body .= '<tr><td>' . $user->employee_number .
                '</td><td>' . $user->username .
                '</td><td>' . $user->firstname .
                '</td><td>' . $user->lastname .
                '</td><td>' . $user->email .
                '</td></tr>';
        }
        $body .= "</tbody>";
        return $body;
    }

    public function ldaptest()
    {
        $settings = Setting::getSettings();

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
                        'firstname'       => $item[$settings['ldap_fname_field']][0] ?? null,
                        'lastname'        => $item[$settings['ldap_lname_field']][0] ?? null,
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
//                    return response()->json($message, 400);
                }
//                return response()->json($message, 200);
            } catch (\Exception $e) {
                \Log::debug('Bind failed');
                \Log::debug("Exception was: ".$e->getMessage());
                return response()->json(['message' => $e->getMessage()], 400);//return response()->json(['message' => $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed but we cannot debug it any further on our end.');
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }}

//    public function ldaptestlogin()
//    {
//
//        if ($this->setting->ldap_enabled != '1') {
//            \Log::debug('LDAP is not enabled. Cannot test.');
//            return response()->json(['message' => 'LDAP is not enabled, cannot test.'], 400);
//        }
//
//
//        $rules = array(
//            'ldaptest_user' => 'required',
//            'ldaptest_password' => 'required'
//        );
//
//        $validator = Validator::make($request->all(), $rules);
//        if ($validator->fails()) {
//            \Log::debug('LDAP Validation test failed.');
//            $validation_errors = implode(' ',$validator->errors()->all());
//            return response()->json(['message' => $validator->errors()->all()], 400);
//        }
//
//
//
//        \Log::debug('Preparing to test LDAP login');
//        try {
//            $connection = Ldap::connectToLdap();
//            try {
//                Ldap::bindAdminToLdap($connection);
//                \Log::debug('Attempting to bind to LDAP for LDAP test');
//                try {
//                    $ldap_user = Ldap::findAndBindUserLdap($this->ldaptest_user, $this->ldaptest_password);
//                    if ($ldap_user) {
//                        \Log::debug('It worked! '. $this->ldaptest_user.' successfully binded to LDAP.');
//                        return response()->json(['message' => 'It worked! '. $this->ldaptest_user.' successfully binded to LDAP.'], 200);
//                    }
//                    return response()->json(['message' => 'Login Failed. '. $this->ldaptest_user.' did not successfully bind to LDAP.'], 400);
//
//                } catch (\Exception $e) {
//                    \Log::debug('LDAP login failed');
//                    return response()->json(['message' => $e->getMessage()], 400);
//                }
//
//            } catch (\Exception $e) {
//                \Log::debug('Bind failed');
//                return response()->json(['message' => $e->getMessage()], 400);
//                //return response()->json(['message' => $e->getMessage()], 500);
//            }
//        } catch (\Exception $e) {
//            \Log::debug('Connection failed');
//            return response()->json(['message' => $e->getMessage()], 500);
//        }
//
//
//    }
//}
