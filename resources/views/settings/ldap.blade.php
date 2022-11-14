@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update LDAP/AD Settings
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>

    @if ((!function_exists('ldap_connect')) || (!function_exists('ldap_set_option')) || (!function_exists('ldap_bind')))
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        {{ trans('admin/settings/general.ldap_extension_warning') }}
                    </div>
                </div>
            </div>
        </div>

    @endif


    {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'false', 'class' => 'form-horizontal', 'role' => 'form']) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <!-- this is a hack to prevent Chrome from trying to autocomplete fields -->
    <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
    <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fas fa-sitemap"></i> {{ trans('admin/settings/general.ldap_ad') }}
                    </h4>
                </div>
                <div class="box-body">


                    <div class="col-md-11 col-md-offset-1">

                        <!-- Enable LDAP -->
                        <div class="form-group {{ $errors->has('ldap_integration') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_integration', trans('admin/settings/general.ldap_integration')) }}
                            </div>
                            <div class="col-md-9">

                                {{ Form::checkbox('ldap_enabled', '1', Request::old('ldap_enabled', $setting->ldap_enabled), [((config('app.lock_passwords')===true)) ? 'disabled ': '', 'class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.ldap_enabled') }}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Password Sync -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('ldap_pw_sync', trans('admin/settings/general.ldap_pw_sync')) }}
                            </div>
                            <div class="col-md-9">

                                {{ Form::checkbox('ldap_pw_sync', '1', Request::old('ldap_pw_sync', $setting->ldap_pw_sync), [((config('app.lock_passwords')===true)) ? 'disabled ': '', 'class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('general.yes') }}

                                <p class="help-block">{{ trans('admin/settings/general.ldap_pw_sync_help') }}</p>
                                {!! $errors->first('ldap_pw_sync_help', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif

                            </div>
                        </div>

                        <!-- AD Flag -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('is_ad', trans('admin/settings/general.ad')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('is_ad', '1', Request::old('is_ad', $setting->is_ad), [((config('app.lock_passwords')===true)) ? 'disabled ': '', 'class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.is_ad') }}
                                {!! $errors->first('is_ad', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}

                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- AD Domain -->
                        <div class="form-group {{ $errors->has('ad_domain') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ad_domain', trans('admin/settings/general.ad_domain')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ad_domain', Request::old('ad_domain', $setting->ad_domain), ['class' => 'form-control','placeholder' => trans('general.example') .'example.com', $setting->demoMode]) }}
                                <p class="help-block">{{ trans('admin/settings/general.ad_domain_help') }}</p>
                                {!! $errors->first('ad_domain', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div><!-- AD Domain -->

                        {{-- NOTICE - this was a feature for AdLdap2-based LDAP syncing, and is already handled in 'classic' LDAP, so we now hide the checkbox (but haven't deleted the field) <!-- AD Append Domain -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('ad_append_domain', trans('admin/settings/general.ad_append_domain_label')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('ad_append_domain', '1', Request::old('ad_append_domain', $setting->ad_append_domain),['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.ad_append_domain') }}
                                <p class="help-block">{{ trans('admin/settings/general.ad_append_domain_help') }}</p>
                                {!! $errors->first('ad_append_domain', '<span class="alert-msg">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div> --}}

                        <!-- LDAP Client-Side TLS key -->
                        <div class="form-group {{ $errors->has('ldap_client_tls_key') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_client_tls_key', trans('admin/settings/general.ldap_client_tls_key')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::textarea('ldap_client_tls_key', Request::old('ldap_client_tls_key', $setting->ldap_client_tls_key), ['class' => 'form-control','placeholder' =>  trans('general.example') .'-----BEGIN RSA PRIVATE KEY-----'."\r\n1234567890\r\n-----END RSA PRIVATE KEY-----
", $setting->demoMode]) }}
                                {!! $errors->first('ldap_client_tls_key', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div><!-- LDAP Client-Side TLS key -->

                        <!-- LDAP Client-Side TLS certificate -->
                        <div class="form-group {{ $errors->has('ldap_client_tls_cert') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_client_tls_cert', trans('admin/settings/general.ldap_client_tls_cert')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::textarea('ldap_client_tls_cert', Request::old('ldap_client_tls_cert', $setting->ldap_client_tls_cert), ['class' => 'form-control','placeholder' =>  trans('general.example') .'-----BEGIN CERTIFICATE-----'."\r\n1234567890\r\n-----END CERTIFICATE-----", $setting->demoMode]) }}
                                <p class="help-block">{{ trans('admin/settings/general.ldap_client_tls_cert_help') }}</p>
                                {!! $errors->first('ldap_client_tls_cert', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div><!-- LDAP Client-Side TLS certificate -->

                        <!-- LDAP Server -->
                        <div class="form-group {{ $errors->has('ldap_server') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_server', trans('admin/settings/general.ldap_server')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_server', Request::old('ldap_server', $setting->ldap_server), ['class' => 'form-control','placeholder' =>  trans('general.example') .'ldap://ldap.example.com', $setting->demoMode]) }}
                                <p class="help-block">{{ trans('admin/settings/general.ldap_server_help') }}</p>
                                {!! $errors->first('ldap_server', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div><!-- LDAP Server -->

                        <!-- Start TLS -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('ldap_tls', trans('admin/settings/general.ldap_tls')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('ldap_tls', '1', Request::old('ldap_tls', $setting->ldap_tls),['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.ldap_tls_help') }}
                                {!! $errors->first('ldap_tls', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Ignore LDAP Certificate -->
                        <div class="form-group {{ $errors->has('ldap_server_cert_ignore') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_server_cert_ignore', trans('admin/settings/general.ldap_server_cert')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('ldap_server_cert_ignore', '1', Request::old('ldap_server_cert_ignore', $setting->ldap_server_cert_ignore),['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.ldap_server_cert_ignore') }}
                                {!! $errors->first('ldap_server_cert_ignore', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                <p class="help-block">{{ trans('admin/settings/general.ldap_server_cert_help') }}</p>
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Username -->
                        <div class="form-group {{ $errors->has('ldap_uname') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_uname', trans('admin/settings/general.ldap_uname')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_uname', Request::old('ldap_uname', $setting->ldap_uname), ['class' => 'form-control','placeholder' => trans('general.example') .'binduser@example.com', $setting->demoMode]) }}
                                {!! $errors->first('ldap_uname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP pword -->
                        <div class="form-group {{ $errors->has('ldap_pword') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_pword', trans('admin/settings/general.ldap_pword')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::password('ldap_pword', ['class' => 'form-control','placeholder' => trans('general.example') .' binduserpassword', $setting->demoMode]) }}
                                {!! $errors->first('ldap_pword', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP basedn -->
                        <div class="form-group {{ $errors->has('ldap_basedn') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_basedn', trans('admin/settings/general.ldap_basedn')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_basedn', Request::old('ldap_basedn', $setting->ldap_basedn), ['class' => 'form-control', 'placeholder' => trans('general.example') .'cn=users/authorized,dc=example,dc=com', $setting->demoMode]) }}
                                {!! $errors->first('ldap_basedn', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP filter -->
                        <div class="form-group {{ $errors->has('ldap_filter') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_filter', trans('admin/settings/general.ldap_filter')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_filter', Request::old('ldap_filter', $setting->ldap_filter), ['class' => 'form-control','placeholder' => trans('general.example') .'&(cn=*)', $setting->demoMode]) }}
                                {!! $errors->first('ldap_filter', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP  username field-->
                        <div class="form-group {{ $errors->has('ldap_username_field') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_username_field', trans('admin/settings/general.ldap_username_field')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_username_field', Request::old('ldap_username_field', $setting->ldap_username_field), ['class' => 'form-control','placeholder' => trans('general.example') .'samaccountname', $setting->demoMode]) }}
                                {!! $errors->first('ldap_username_field', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Last Name Field -->
                        <div class="form-group {{ $errors->has('ldap_lname_field') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_lname_field', trans('admin/settings/general.ldap_lname_field')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_lname_field', Request::old('ldap_lname_field', $setting->ldap_lname_field), ['class' => 'form-control','placeholder' => trans('general.example') .'sn', $setting->demoMode]) }}
                                {!! $errors->first('ldap_lname_field', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP First Name field -->
                        <div class="form-group {{ $errors->has('ldap_fname_field') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_fname_field', trans('admin/settings/general.ldap_fname_field')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_fname_field', Request::old('ldap_fname_field', $setting->ldap_fname_field), ['class' => 'form-control', 'placeholder' => trans('general.example') .'givenname', $setting->demoMode]) }}
                                {!! $errors->first('ldap_fname_field', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Auth Filter Query -->
                        <div class="form-group {{ $errors->has('ldap_auth_filter_query') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_auth_filter_query', trans('admin/settings/general.ldap_auth_filter_query')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_auth_filter_query', Request::old('ldap_auth_filter_query', $setting->ldap_auth_filter_query), ['class' => 'form-control','placeholder' => trans('general.example') .'uid=', $setting->demoMode]) }}
                                {!! $errors->first('ldap_auth_filter_query', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Version -->
                        <div class="form-group {{ $errors->has('ldap_version') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_version', trans('admin/settings/general.ldap_version')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_version', Request::old('ldap_version', $setting->ldap_version), ['class' => 'form-control','placeholder' => '3', $setting->demoMode]) }}
                                {!! $errors->first('ldap_version', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP active flag -->
                        <div class="form-group {{ $errors->has('ldap_active_flag') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_active_flag', trans('admin/settings/general.ldap_active_flag')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_active_flag', Request::old('ldap_active_flag', $setting->ldap_active_flag), ['class' => 'form-control', $setting->demoMode]) }}

                                <p class="help-block">{!! trans('admin/settings/general.ldap_activated_flag_help') !!}</p>

                                {!! $errors->first('ldap_active_flag', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP emp number -->
                        <div class="form-group {{ $errors->has('ldap_emp_num') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_emp_num', trans('admin/settings/general.ldap_emp_num')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_emp_num', Request::old('ldap_emp_num', $setting->ldap_emp_num), ['class' => 'form-control','placeholder' => trans('general.example') .'employeenumber/employeeid', $setting->demoMode]) }}
                                {!! $errors->first('ldap_emp_num', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>
                        <!-- LDAP department -->
                        <div class="form-group {{ $errors->has('ldap_dept') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_dept', trans('admin/settings/general.ldap_dept')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_dept', Request::old('ldap_dept', $setting->ldap_dept), ['class' => 'form-control','placeholder' => trans('general.example') .'department', $setting->demoMode]) }}
                                {!! $errors->first('ldap_dept', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>
                        <!-- LDAP Manager -->
                        <div class="form-group {{ $errors->has('ldap_dept') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_dept', trans('admin/settings/general.ldap_manager')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_manager', Request::old('ldap_manager', $setting->ldap_manager), ['class' => 'form-control','placeholder' => trans('general.example') .'manager', $setting->demoMode]) }}
                                {!! $errors->first('ldap_manager', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP email -->
                        <div class="form-group {{ $errors->has('ldap_email') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_email', trans('admin/settings/general.ldap_email')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_email', Request::old('ldap_email', $setting->ldap_email), ['class' => 'form-control','placeholder' => trans('general.example') .'mail', $setting->demoMode]) }}
                                {!! $errors->first('ldap_email', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Phone -->
                        <div class="form-group {{ $errors->has('ldap_phone') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_phone', trans('admin/settings/general.ldap_phone')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_phone', Request::old('ldap_phone', $setting->ldap_phone_field), ['class' => 'form-control','placeholder' => trans('general.example') .'telephonenumber', $setting->demoMode]) }}
                                {!! $errors->first('ldap_phone', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Job title -->
                        <div class="form-group {{ $errors->has('ldap_jobtitle') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_jobtitle', trans('admin/settings/general.ldap_jobtitle')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_jobtitle', Request::old('ldap_jobtitle', $setting->ldap_jobtitle), ['class' => 'form-control','placeholder' => trans('general.example') .'title', $setting->demoMode]) }}
                                {!! $errors->first('ldap_jobtitle', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- LDAP Country -->
                        <div class="form-group {{ $errors->has('ldap_country') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_country', trans('admin/settings/general.ldap_country')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_country', Request::old('ldap_country', $setting->ldap_country), ['class' => 'form-control','placeholder' => trans('general.example') .'c', $setting->demoMode]) }}
                                {!! $errors->first('ldap_country', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>
                        @if ($setting->ldap_enabled)

                            <!-- LDAP test -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('test_ldap_sync', 'Test LDAP Sync') }}
                                </div>
                                <div class="col-md-9" id="ldaptestrow">
                                    <a {{ $setting->demoMode }} class="btn btn-default btn-sm pull-left" id="ldaptest" style="margin-right: 10px;">{{ trans('admin/settings/general.ldap_test_sync') }}</a>
                                </div>
                                <div class="col-md-9 col-md-offset-3">
                                    <br />
                                    <div id="ldapad_test_results" class="hidden well well-sm"></div>
                                </div>
                                <div class="col-md-9 col-md-offset-3">
                                    <p class="help-block">{{ trans('admin/settings/general.ldap_login_sync_help') }}</p>
                                    @if (config('app.lock_passwords')===true)
                                        <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                    @endif
                                </div>

                            </div>

                            <!-- LDAP Login test -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('test_ldap_login', 'Test LDAP Login') }}
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="ldaptest_user" id="ldaptest_user"  class="form-control" placeholder="LDAP username">
                                    </div>
                                    <div class="col-md-4">
                                    <input type="password" name="ldaptest_password" id="ldaptest_password" class="form-control" placeholder="LDAP password">
                                    </div>
                                    <div class="col-md-3">
                                        <a class="btn btn-default btn-sm" id="ldaptestlogin" style="margin-right: 10px;">{{ trans('admin/settings/general.ldap_test') }}</a>
                                    </div>


                                </div>
                                </div>
                                <div class="col-md-9 col-md-offset-3">
                                    <span id="ldaptestloginicon"></span>
                                    <span id="ldaptestloginresult"></span>
                                    <span id="ldaptestloginstatus"></span>
                                </div>
                                <div class="col-md-9 col-md-offset-3">
                                    <p class="help-block">{{ trans('admin/settings/general.ldap_login_test_help') }}</p>
                                </div>

                        </div>


                       @endif

                        <!-- LDAP Forgotten password -->
                        <div class="form-group {{ $errors->has('custom_forgot_pass_url') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('custom_forgot_pass_url', trans('admin/settings/general.custom_forgot_pass_url')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('custom_forgot_pass_url', Request::old('custom_forgot_pass_url', $setting->custom_forgot_pass_url), ['class' => 'form-control','placeholder' => trans('general.example') .'https://my.ldapserver-forgotpass.com', $setting->demoMode]) }}
                                <p class="help-block">{{ trans('admin/settings/general.custom_forgot_pass_url_help') }}</p>
                                {!! $errors->first('custom_forgot_pass_url', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div><!-- LDAP Server -->


                    </div>
                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->

        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}


@stop

@push('js')
    <script nonce="{{ csrf_token() }}">

        /**
         * Check to see if is_ad is checked, if not disable the ad_domain field
         */
        $(function() {
            if( $('#is_ad').prop('checked') === false) {
                $('#ad_domain').prop('disabled', 'disabled');
            } else {
                //$('#ldap_server').prop('disabled', 'disabled');
            }
        });

        /**
         * Toggle the server info based on the is_ad checkbox
         */
        $('#is_ad').on('ifClicked', function(){
            $('#ad_domain').toggleDisabled();
            //$('#ldap_server').toggleDisabled();
        });


        /**
         * Test the LDAP connection settings
         */
        $("#ldaptest").click(function () {
            $("#ldapad_test_results").removeClass('hidden text-success text-danger');
            $("#ldapad_test_results").html('');
            $("#ldapad_test_results").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.ldap.testing') }}');
            $.ajax({
                url: '{{ route('api.settings.ldaptest') }}',
                type: 'GET',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                dataType: 'json',

                success: function (data) {
                    $("#ldapad_test_results").html('');
                    let html = buildLdapTestResults(data)
                    $("#ldapad_test_results").html(
                        html
                    );
                },

                error: function (data) {
                    $("#ldapad_test_results").html('');
                    $("#ldapad_test_results").addClass('text-danger');
                    let errorIcon = '<i class="fas fa-exclamation-triangle text-danger"></i>' + ' ';
                    if (data.status == 500) {
                        $('#ldapad_test_results').html(errorIcon + '{{ trans('admin/settings/message.ldap.500') }}');
                    } else if (data.status == 400) {
                        let errorMessage = '';
                        if( typeof data.responseJSON.user_sync !== 'undefined') {
                            errorMessage =  data.responseJSON.user_sync.message;
                        }
                        if( typeof data.responseJSON.message !== 'undefined') {
                            errorMessage =  data.responseJSON.message;
                        }
                        $('#ldapad_test_results').html(errorIcon + errorMessage);
                    } else {
                        $('#ldapad_test_results').html('{{ trans('admin/settings/message.ldap.error') }}');
                       // $('#ldapad_test_results').html(errorIcon + data.responseText.message);
                    }
                }


            });
        });

        /**
         * Build the results html table
         */
        function buildLdapTestResults(results) {
            let html = '<ul style="list-style: none;padding-left: 5px;">'
            html += '<li class="text-success"><i class="fas fa-check" aria-hidden="true"></i> ' + results.login.message + ' </li>'
            html += '<li class="text-success"><i class="fas fa-check" aria-hidden="true"></i> ' + results.bind.message + ' </li>'
            html += '</ul>'
            html += '<div>{{ trans('admin/settings/message.ldap.sync_success') }}</div>'
            html += '<table class="table table-bordered table-condensed" style="background-color: #fff">'
            html += buildLdapResultsTableHeader()
            html += buildLdapResultsTableBody(results.user_sync.users)
            html += '<table>'
            return html;
        }

        function buildLdapResultsTableHeader(user)
        {
            var keys = [
                '{{ trans('admin/settings/general.employee_number') }}',
                '{{ trans('mail.username') }}',
                '{{ trans('general.first_name') }}',
                '{{ trans('general.last_name') }}',
                '{{ trans('general.email') }}'
            ]
            let header = '<thead><tr>'
            for (var i in keys) {
                header += '<th>' + keys[i] + '</th>'
            }
            header += "</tr></thead>"
            return header;
        }

        function buildLdapResultsTableBody(users)
        {
            let body = '<tbody>'
            for (var i in users) {
                body += '<tr><td>' + users[i].employee_number + '</td><td>' + users[i].username + '</td><td>' + users[i].firstname + '</td><td>' + users[i].lastname + '</td><td>' + users[i].email + '</td></tr>'
            }
            body += "</tbody>"
            return body;
        }

        $("#ldaptestlogin").click(function(){
            $("#ldaptestloginrow").removeClass('text-success');
            $("#ldaptestloginrow").removeClass('text-danger');
            $("#ldaptestloginstatus").removeClass('text-danger');
            $("#ldaptestloginstatus").html('');
            $("#ldaptestloginicon").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.ldap.testing_authentication') }}');
            $.ajax({
                url: '{{ route('api.settings.ldaptestlogin') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'ldaptest_user': $('#ldaptest_user').val(),
                    'ldaptest_password': $('#ldaptest_password').val()
                },

                dataType: 'json',

                success: function (data) {
                    $("#ldaptestloginicon").html('');
                    $("#ldaptestloginrow").addClass('text-success');
                    $("#ldaptestloginstatus").addClass('text-success');
                    $("#ldaptestloginstatus").html('<i class="fas fa-check text-success"></i> {{ trans('admin/settings/message.ldap.authentication_success') }}');
                },

                error: function (data) {

                    if (data.responseJSON) {
                        var errors = data.responseJSON.message;
                    } else {
                        var errors;
                    }

                    var error_text = '';

                    $("#ldaptestloginicon").html('');
                    $("#ldaptestloginstatus").addClass('text-danger');
                    $("#ldaptestloginicon").html('<i class="fas fa-exclamation-triangle text-danger"></i>');

                    if (data.status == 500) {
                        $('#ldaptestloginstatus').html('{{ trans('admin/settings/message.ldap.500') }}');
                    } else if (data.status == 400) {

                        if (typeof errors !='string') {

                            for (i = 0; i < errors.length; i++) {
                                if (errors[i]) {
                                    error_text += '<li>Error: ' + errors[i];
                                }

                            }

                        } else {
                            error_text = errors;
                        }

                        $('#ldaptestloginstatus').html(error_text);

                    } else {
                        $('#ldaptestloginstatus').html(data.responseText.message);
                    }
                }




            });
        });
    </script>
@endpush
