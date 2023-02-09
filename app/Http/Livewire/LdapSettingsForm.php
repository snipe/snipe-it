<?php

namespace App\Http\Livewire;

use App\Models\Setting;
use App\Models\Group;
use Livewire\Component;

class LdapSettingsForm extends Component
{
    public bool $ldap_enabled;
      public       $ldap_server;
//    public       $ldap_server_cert_ignore,
//    public       $ldap_uname,
//    public       $ldap_pword,
//    public       $ldap_basedn,
//    public       $ldap_filter,
//    public       $ldap_username_field,
//    public       $ldap_lname_field,
//    public       $ldap_fname_field,
//    public       $ldap_auth_filter_query,
//    public       $ldap_version,
//    public       $ldap_active_flag,
//    public       $ldap_emp_num,
//    public       $ldap_email,
//    public       $ldap_manager,
      public string $ad_domain;
      public bool   $is_ad;
//    public       $ad_append_domain,
//    public       $ldap_tls,
      public bool   $ldap_pw_sync;
//    public       $custom_forgot_pass_url,
//    public       $ldap_phone_field,
//    public       $ldap_jobtitle,
//    public       $ldap_country,
//    public       $ldap_dept,
      public        $ldap_client_tls_cert;
      public        $ldap_client_tls_key;
      public        $ldap_default_group;
      public        $groups;

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
}
