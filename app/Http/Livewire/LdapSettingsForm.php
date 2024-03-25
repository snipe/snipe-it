<?php

namespace App\Http\Livewire;

use App\Models\Ldap;
use App\Models\Setting;
use App\Models\Group;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

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
      public        $ldap_jobtitle;
      public        $ldap_country;
      public        $ldap_dept;
      public        $ldap_client_tls_cert;
      public        $ldap_client_tls_key;
      public        $ldap_default_group;
      public        $ldap_company;
      public        $ldap_phone_field;
      public        $groups;
      public        $ldaptest_user;
      public        $ldaptest_password;
      public        $ldap_sync_test_users;
      public        $keys = [];
      public        $ldap_message;
      public        $test_login;
      public        $custom_forgot_pass_url;




    protected $rules = [
          'ldap_username_field' => 'not_in:sAMAccountName',
          'ldap_auth_filter_query' => 'not_in:uid=samaccountname|required_if:ldap_enabled,1',
          'ldap_filter' => 'nullable|regex:"^[^(]"|required_if:ldap_enabled,1',
          'ldaptest_user' => 'required',
          'ldaptest_password' => 'required'
      ];
    protected $hidden = [
        'ldap_pword',
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
        $this->ldap_phone_field          = $this->setting->ldap_phone_field;
        $this->ldap_jobtitle             = $this->setting->ldap_jobtitle;
        $this->ldap_country              = $this->setting->ldap_country;
        $this->ldap_dept                 = $this->setting->ldap_dept;
        $this->ldap_client_tls_cert      = $this->setting->ldap_client_tls_cert;
        $this->ldap_client_tls_key       = $this->setting->ldap_client_tls_key;
        $this->custom_forgot_pass_url    = $this->setting->custom_forgot_pass_url;
        $this->ldap_company              = $this->setting->ldap_company;

    }

    public function render(){

        return view('livewire.ldap-settings-form');
    }


    public function submit(){
        if (! config('app.lock_passwords') === true) {
            $this->setting->ldap_enabled = $this->ldap_enabled;
            $this->setting->ldap_server = $this->ldap_server;
            $this->setting->ldap_server_cert_ignore = $this->ldap_server_cert_ignore;
            $this->setting->ldap_uname = $this->ldap_uname;
            $this->setting->ldap_pword = Crypt::encrypt($this->ldap_pword);
            $this->setting->ldap_basedn = $this->ldap_basedn;
            $this->setting->ldap_default_group = $this->ldap_default_group;
            $this->setting->ldap_filter = $this->ldap_filter;
            $this->setting->ldap_username_field = $this->ldap_username_field;
            $this->setting->ldap_lname_field = $this->ldap_lname_field;
            $this->setting->ldap_fname_field = $this->ldap_fname_field;
            $this->setting->ldap_auth_filter_query = $this->ldap_auth_filter_query;
            $this->setting->ldap_version = $this->ldap_version;
            $this->setting->ldap_active_flag = $this->ldap_active_flag;
            $this->setting->ldap_emp_num = $this->ldap_emp_num;
            $this->setting->ldap_email = $this->ldap_email;
            $this->setting->ldap_manager = $this->ldap_manager;
            $this->setting->ad_domain = $this->ad_domain;
            $this->setting->is_ad = $this->is_ad;
            $this->setting->ad_append_domain = $this->ad_append_domain;
            $this->setting->ldap_tls = $this->ldap_tls;
            $this->setting->ldap_pw_sync = $this->ldap_pw_sync;
            $this->setting->ldap_phone_field = $this->ldap_phone_field;
            $this->setting->ldap_jobtitle = $this->ldap_jobtitle;
            $this->setting->ldap_country = $this->ldap_country;
            $this->setting->ldap_dept = $this->ldap_dept;
            $this->setting->ldap_client_tls_cert = $this->ldap_client_tls_cert;
            $this->setting->ldap_client_tls_key = $this->ldap_client_tls_key;
            $this->setting->custom_forgot_pass_url = $this->custom_forgot_pass_url;
        }
        $this->ldap_sync_test_users=null;

        $this->setting->save();
        $this->setting->update_client_side_cert_files();
        session()->flash('saved', 'Settings Saved.');
    }

    public function ldapsynctest()
    {
        $settings = Setting::getSettings();

        \Log::debug('Preparing to test LDAP connection');

         //where we collect together test messages
        try {
            $connection = Ldap::connectToLdap();
            try {
                $this->ldap_message = 'Successfully bound to LDAP server.';
                \Log::debug('attempting to bind to LDAP for LDAP test');
                Ldap::bindAdminToLdap($connection);
                $this->ldap_message .= ' Successfully connected to LDAP server.';

                $users = collect(Ldap::findLdapUsers(null,10))
                    ->filter(function ($value, $key) {
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
                if (isset($users)) {
                    $this->ldap_sync_test_users = $users->toArray();
                    return session()->flash('sync_success', $this->ldap_message);

                } else {
                    return session()->flash('sync_empty',' Connection to LDAP was successful, however there were no users returned from your query. You should confirm the Base Bind DN above.' );

                }
            } catch (\Exception $e) {
                \Log::debug('Bind failed');
                \Log::debug("Exception was: ".$e->getMessage());
                return session()->flash('sync_bind_fail', 'Bind failed. Be sure: 1) LDAP settings are filled correctly and saved. 2) Bind Username and Password are correct.  ');
            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed but we cannot debug it any further on our end.');
                return session()->flash('unknown_sync_fail');

        }
    }
    public function updated(){

        $this->ldap_sync_test_users = null;

    }

    public function ldaptestlogin()
    {
        $this->ldap_sync_test_users = null;

        $this->validate($this->rules);

        \Log::debug('Preparing to test LDAP login');

        try {
            $connection = Ldap::connectToLdap();
            try {
                Ldap::bindAdminToLdap($connection);
                \Log::debug('Attempting to bind to LDAP for LDAP test');
                try {
                    $ldap_user = Ldap::findAndBindUserLdap($this->ldaptest_user, $this->ldaptest_password);
                    if ($ldap_user) {
                        \Log::debug('It worked! '. $this->ldaptest_user.' successfully binded to LDAP.');
                        return session()->flash('success','It worked!'. $this->ldatest_user.' succesfully binded to LDAP.');
                    }
                    return  session()->flash('bind_fail', 'Login Failed. '. $this->ldaptest_user.' did not successfully bind to LDAP.');

                } catch (\Exception $e) {
                    \Log::debug('LDAP login failed');
                    return  session()->flash('login_fail', 'Login Failed. '. $this->ldaptest_user.' did not successfully bind to LDAP.');

                }

            } catch (\Exception $e) {
                \Log::debug('Bind failed');

                return session()->flash('bind_fail_general','Could not bind to LDAP: Invalid credentials');

            }
        } catch (\Exception $e) {
            \Log::debug('Connection failed');
            return session()->flash('connection_fail','Connection failed.');
        }

    }
}
