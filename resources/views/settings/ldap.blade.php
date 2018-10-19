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
                       It doesn't look like the LDAP extension is installed or enabled on this server. :(
                    </div>
                </div>
            </div>
        </div>

    @else


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
                    <h4 class="box-title">
                        <i class="fa fa-sitemap"></i> LDAP/AD
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
                                {{ Form::checkbox('ldap_enabled', '1', Input::old('ldap_enabled', $setting->ldap_enabled), ['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.ldap_enabled') }}
                                {!! $errors->first('ldap_enabled', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP Password Sync -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('ldap_pw_sync', trans('admin/settings/general.ldap_pw_sync')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('ldap_pw_sync', '1', Input::old('ldap_pw_sync', $setting->ldap_pw_sync),['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('general.yes') }}
                                <p class="help-block">{{ trans('admin/settings/general.ldap_pw_sync_help') }}</p>
                                {!! $errors->first('ldap_pw_sync', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- AD Flag -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('is_ad', trans('admin/settings/general.ad')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('is_ad', '1', Input::old('is_ad', $setting->is_ad),['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.is_ad') }}
                                {!! $errors->first('is_ad', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>                        

                        <!-- AD Domain -->
                        <div class="form-group {{ $errors->has('ad_domain') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ad_domain', trans('admin/settings/general.ad_domain')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ad_domain', Input::old('ad_domain', $setting->ad_domain), ['class' => 'form-control','placeholder' => 'example.com', $setting->demoMode]) }}
                                <p class="help-block">{{ trans('admin/settings/general.ad_domain_help') }}</p>
                                {!! $errors->first('ad_domain', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div><!-- AD Domain -->

                        <!-- LDAP Server -->
                        <div class="form-group {{ $errors->has('ldap_server') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_server', trans('admin/settings/general.ldap_server')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_server', Input::old('ldap_server', $setting->ldap_server), ['class' => 'form-control','placeholder' => 'ldap://ldap.example.com', $setting->demoMode]) }}
                                <p class="help-block">{{ trans('admin/settings/general.ldap_server_help') }}</p>
                                {!! $errors->first('ldap_server', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div><!-- LDAP Server -->

                        <!-- Start TLS -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('ldap_tls', trans('admin/settings/general.ldap_tls')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('ldap_tls', '1', Input::old('ldap_tls', $setting->ldap_tls),['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.ldap_tls_help') }}
                                {!! $errors->first('ldap_tls', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Ignore LDAP Certificate -->
                        <div class="form-group {{ $errors->has('ldap_server_cert_ignore') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_server_cert_ignore', trans('admin/settings/general.ldap_server_cert')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('ldap_server_cert_ignore', '1', Input::old('ldap_server_cert_ignore', $setting->ldap_server_cert_ignore),['class' => 'minimal '. $setting->demoMode, $setting->demoMode]) }}
                                {{ trans('admin/settings/general.ldap_server_cert_ignore') }}
                                {!! $errors->first('ldap_server_cert_ignore', '<span class="alert-msg">:message</span>') !!}
                                <p class="help-block">{{ trans('admin/settings/general.ldap_server_cert_help') }}</p>
                            </div>
                        </div>

                        <!-- LDAP Username -->
                        <div class="form-group {{ $errors->has('ldap_uname') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_uname', trans('admin/settings/general.ldap_uname')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_uname', Input::old('ldap_uname', $setting->ldap_uname), ['class' => 'form-control','placeholder' => 'binduser@example.com', $setting->demoMode]) }}
                                {!! $errors->first('ldap_uname', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP pword -->
                        <div class="form-group {{ $errors->has('ldap_pword') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_pword', trans('admin/settings/general.ldap_pword')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::password('ldap_pword', ['class' => 'form-control','placeholder' => 'binduserpassword', $setting->demoMode]) }}
                                {!! $errors->first('ldap_pword', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP basedn -->
                        <div class="form-group {{ $errors->has('ldap_basedn') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_basedn', trans('admin/settings/general.ldap_basedn')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_basedn', Input::old('ldap_basedn', $setting->ldap_basedn), ['class' => 'form-control', 'placeholder' => 'cn=users/authorized,dc=example,dc=com', $setting->demoMode]) }}
                                {!! $errors->first('ldap_basedn', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP filter -->
                        <div class="form-group {{ $errors->has('ldap_filter') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_filter', trans('admin/settings/general.ldap_filter')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_filter', Input::old('ldap_filter', $setting->ldap_filter), ['class' => 'form-control','placeholder' => '&(cn=*)', $setting->demoMode]) }}
                                {!! $errors->first('ldap_filter', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP  username field-->
                        <div class="form-group {{ $errors->has('ldap_username_field') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_username_field', trans('admin/settings/general.ldap_username_field')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_username_field', Input::old('ldap_username_field', $setting->ldap_username_field), ['class' => 'form-control','placeholder' => 'samaccountname', $setting->demoMode]) }}
                                {!! $errors->first('ldap_username_field', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP Last Name Field -->
                        <div class="form-group {{ $errors->has('ldap_lname_field') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_lname_field', trans('admin/settings/general.ldap_lname_field')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_lname_field', Input::old('ldap_lname_field', $setting->ldap_lname_field), ['class' => 'form-control','placeholder' => 'sn', $setting->demoMode]) }}
                                {!! $errors->first('ldap_lname_field', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP First Name field -->
                        <div class="form-group {{ $errors->has('ldap_fname_field') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_fname_field', trans('admin/settings/general.ldap_fname_field')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_fname_field', Input::old('ldap_fname_field', $setting->ldap_fname_field), ['class' => 'form-control', 'placeholder' => 'givenname', $setting->demoMode]) }}
                                {!! $errors->first('ldap_fname_field', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP Auth Filter Query -->
                        <div class="form-group {{ $errors->has('ldap_auth_filter_query') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_auth_filter_query', trans('admin/settings/general.ldap_auth_filter_query')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_auth_filter_query', Input::old('ldap_auth_filter_query', $setting->ldap_auth_filter_query), ['class' => 'form-control','placeholder' => '"uid="', $setting->demoMode]) }}
                                {!! $errors->first('ldap_auth_filter_query', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP Version -->
                        <div class="form-group {{ $errors->has('ldap_version') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_version', trans('admin/settings/general.ldap_version')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_version', Input::old('ldap_version', $setting->ldap_version), ['class' => 'form-control','placeholder' => '3', $setting->demoMode]) }}
                                {!! $errors->first('ldap_version', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP active flag -->
                        <div class="form-group {{ $errors->has('ldap_active_flag') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_active_flag', trans('admin/settings/general.ldap_active_flag')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_active_flag', Input::old('ldap_active_flag', $setting->ldap_active_flag), ['class' => 'form-control','placeholder' => '', $setting->demoMode]) }}
                                {!! $errors->first('ldap_active_flag', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP emp number -->
                        <div class="form-group {{ $errors->has('ldap_emp_num') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_emp_num', trans('admin/settings/general.ldap_emp_num')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_emp_num', Input::old('ldap_emp_num', $setting->ldap_emp_num), ['class' => 'form-control','placeholder' => '', $setting->demoMode]) }}
                                {!! $errors->first('ldap_emp_num', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- LDAP email -->
                        <div class="form-group {{ $errors->has('ldap_email') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('ldap_email', trans('admin/settings/general.ldap_email')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('ldap_email', Input::old('ldap_email', $setting->ldap_email), ['class' => 'form-control','placeholder' => '', $setting->demoMode]) }}
                                {!! $errors->first('ldap_email', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>


                        @if ($setting->ldap_enabled)

                            <!-- LDAP test -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('test_ldap_sync', 'Test LDAP Sync') }}
                                </div>
                                <div class="col-md-9" id="ldaptestrow">
                                    <a {{ $setting->demoMode }} class="btn btn-default btn-sm pull-left" id="ldaptest" style="margin-right: 10px;">Test LDAP Syncronization</a>
                                </div>
                                <div class="col-md-9 col-md-offset-3">
                                    <br />
                                    <div id="ldapad_test_results" class="hidden well well-sm"></div>
                                </div>
                                <div class="col-md-9 col-md-offset-3">
                                    <p class="help-block">{{ trans('admin/settings/general.ldap_login_sync_help') }}</p>
                                </div>
    
                            </div>

                       @endif

                        <!-- LDAP Forgotten password -->
                        <div class="form-group {{ $errors->has('custom_forgot_pass_url') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('custom_forgot_pass_url', trans('admin/settings/general.custom_forgot_pass_url')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('custom_forgot_pass_url', Input::old('custom_forgot_pass_url', $setting->custom_forgot_pass_url), ['class' => 'form-control','placeholder' => 'https://my.ldapserver-forgotpass.com', $setting->demoMode]) }}
                                <p class="help-block">{{ trans('admin/settings/general.custom_forgot_pass_url_help') }}</p>
                                {!! $errors->first('custom_forgot_pass_url', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div><!-- LDAP Server -->


                    </div>
                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button {{ $setting->demoMode }} type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->

        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}
   @endif

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
            $('#ldap_server').prop('disabled', 'disabled');
        }
    });

    /**
     * Toggle the server info based on the is_ad checkbox
     */
    $('#is_ad').on('ifClicked', function(){
        $('#ad_domain').toggleDisabled();
        $('#ldap_server').toggleDisabled();
    });


    /**
     * Test the LDAP connection settings
     */
    $("#ldaptest").click(function () {
        $("#ldapad_test_results").removeClass('hidden text-success text-danger');
        $("#ldapad_test_results").html('');
        $("#ldapad_test_results").html('<i class="fa fa-spinner spin"></i> Testing LDAP Connection, Binding & Query ...');
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
                let errorIcon = '<i class="fa fa-exclamation-triangle text-danger"></i>' + ' ';
                if (data.status == 500) {
                    $('#ldapad_test_results').html(errorIcon + '500 Server Error');
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
                    $('#ldapad_test_results').html(errorIcon + data.responseText.message);
                }
            }
        });
    });

    /**
     * Build the results html table
     */
    function buildLdapTestResults(results) {
        let html = '<ul style="list-style: none;padding-left: 5px;">'
        html += '<li class="text-success"><i class="fa fa-check" aria-hidden="true"></i> ' + results.login.message + ' </li>'
        html += '<li class="text-success"><i class="fa fa-check" aria-hidden="true"></i> ' + results.bind.message + ' </li>'
        html += '</ul>'
        html += '<div>A sample of 10 users returned from the LDAP server based on your settings:</div>'
        html += '<table class="table table-bordered table-condensed" style="background-color: #fff">'
        html += buildLdapResultsTableHeader()
        html += buildLdapResultsTableBody(results.user_sync.users)
        html += '<table>'
        return html;
    }

    function buildLdapResultsTableHeader(user)
    {
        var keys = ['Employee Number', 'Username', 'First Name', 'Last Name','Email']
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
</script>
@endpush