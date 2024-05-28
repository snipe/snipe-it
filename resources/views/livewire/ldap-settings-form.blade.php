<div>

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
    <form wire:submit.prevent="submit" class="form-horizontal">
        <!-- CSRF Token -->
        {{csrf_field()}}

        <input type="hidden" name="username" value="{{ Request::old('username', $user->username) }}">

        <!-- this is a hack to prevent Chrome from trying to autocomplete fields -->
        <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
        <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />

        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


                <div class="panel box box-default">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <i class="fas fa-sitemap"></i> {{ trans('admin/settings/general.ldap_ad') }}
                        </h4>
                    </div>
                    <div class="box-body">

                        <!-- Enable LDAP -->
                        <div class="col-md-11 col-md-offset-1">
                            <div class="form-group {{ $errors->has('ldap_enabled') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_enabled', trans('admin/settings/general.ldap_integration')) }}
                                </div>
                                <div class="col-md-9">
                                    <label class="form-control">
                                        @if(config('app.lock_passwords')===true)
                                            <input wire:model="ldap_enabled" type="checkbox" value="{{old('$ldap_enabled', $ldap_enabled) }}"  disabled>
                                            @error('$ldap_enabled')<span> class="error">{{$message}}</span>@enderror
                                            <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                        @else
                                            <input wire:model="ldap_enabled" type="checkbox" value="{{old('$ldap_enabled', $ldap_enabled)}}" >
                                            {{ trans('admin/settings/general.ldap_enabled') }}
                                            @error('$ldap_enabled')<span> class="error">{{$message}}</span>@enderror
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <!-- LDAP Password Sync -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_pw_sync', trans('admin/settings/general.ldap_pw_sync')) }}
                                </div>
                                <div class="col-md-9">
                                    <label class="form-control">

                                        @if(config('app.lock_passwords')===true)
                                            <input wire:model="ldap_pw_sync" type="checkbox" value="{{old('$ldap_pw_sync', $ldap_pw_sync) }}"   disabled>
                                            <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                        @else
                                            <input wire:model="ldap_pw_sync" type="checkbox" value="{{old('$ldap_pw_sync', $ldap_pw_sync)}}"   >
                                            {{ trans('general.yes') }}
                                            {!! $errors->first('ldap_pw_sync_help', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                        @endif
                                    </label>
                                    <p class="help-block">{{ trans('admin/settings/general.ldap_pw_sync_help') }}</p>
                                </div>
                            </div>

                            <!--  Default LDAP Permissions Group Select -->
                            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_default_group', trans('admin/settings/general.ldap_default_group')) }}
                                </div>

                                <div class="col-md-9">

                                    @if ($groups->count())
                                        @if ((Config::get('app.lock_passwords') || (!Auth::user()->isSuperUser())))
                                            <ul>
                                                @foreach ($groups as $id => $group)
                                                    {!! '<li>'.e($group).'</li>' !!}
                                                @endforeach
                                            </ul>


                                            <span class="help-block">{{ trans('admin/users/general.group_memberships_helpblock') }}</span>
                                        @else
                                            <div class="controls">
                                                <select
                                                        wire:model.lazy="ldap_default_group"
                                                        aria-label="ldap_default_group"
                                                        id="ldap_default_group"
                                                        class="form-control"
                                                >
                                                    <option value="">{{ trans('admin/settings/general.no_default_group') }}</option>
                                                    @foreach ($groups as $id => $group)
                                                        <option value="{{ $id }}" {{ $setting->ldap_default_group == $id ? 'selected' : '' }}>
                                                            {{ $group->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <span class="help-block">
                                  {{ trans('admin/settings/general.ldap_default_group_info') }}
                                </span>
                                            </div>
                                        @endif
                                    @else
                                        <p>No groups have been created yet. Visit <code>Admin Settings > Permission Groups</code> to add one.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- AD Flag -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('is_ad', trans('admin/settings/general.ad')) }}
                                </div>
                                <div class="col-md-9">
                                    <label class="form-control">
                                        @if(config('app.lock_passwords')===true)
                                            <input wire:model="is_ad" type="checkbox" value="{{old('is_ad', $is_ad) }}"   disabled>
                                            <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                        @else
                                            <input wire:model="is_ad" type="checkbox" value="{{old('is_ad', $is_ad)}}"   >
                                            {{ trans('admin/settings/general.is_ad') }}
                                            {!! $errors->first('is_ad', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <!-- AD Domain -->
                            <div class="form-group {{ $errors->has('ad_domain') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ad_domain', trans('admin/settings/general.ad_domain')) }}
                                </div>
                                <div class="col-md-9">
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ad_domain" type="text" class="form-control" placeholder="{{trans('general.example').'example.com'}} " disabled>
                                        <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{trans('general.feature_disabled') }}</p>
                                    @else
                                        <input wire:model.lazy="ad_domain" type="text" class="form-control" placeholder="{{trans('general.example').'example.com'}}" >
                                        <p class="help-block">{{ trans('admin/settings/general.ad_domain_help') }}</p>
                                        {!! $errors->first('ad_domain', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @endif
                                </div>
                            </div><!-- AD Domain -->

                            <!-- LDAP Client-Side TLS key -->
                            <div class="form-group {{ $errors->has('ldap_client_tls_key') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_client_tls_key', trans('admin/settings/general.ldap_client_tls_key')) }}
                                </div>
                                <div class="col-md-9">
                            <textarea wire:model.lazy="ldap_client_tls_key" rows="10" class="form-control" placeholder="{{trans('general.example') .'-----BEGIN RSA PRIVATE KEY-----'."\r\n1234567890\r\n-----END RSA PRIVATE KEY-----"}}">
                            {{old('ldap_client_tls_key', $ldap_client_tls_key)}}</textarea>
                                    {!! $errors->first('ldap_client_tls_key', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <textarea wire:model.lazy="ldap_client_tls_key" rows="10" class="form-control" placeholder="{{trans('general.example') .'-----BEGIN RSA PRIVATE KEY-----'."\r\n1234567890\r\n-----END RSA PRIVATE KEY-----"}}" disabled>
                                {{old('ldap_client_tls_key', $ldap_client_tls_key)}}</textarea>
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
                                    @if (config('app.lock_passwords')===true)
                                        <textarea wire:model.lazy="ldap_client_tls_cert" rows="10" class="form-control" placeholder="{{trans('general.example') .'-----BEGIN CERTIFICATE-----'."\r\n1234567890\r\n-----END CERTIFICATE-----"}}">
                                {{old('ldap_client_tls_cert', $ldap_client_tls_cert)}}</textarea><p class="text-warning">
                                        <p><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                    @else
                                        <textarea wire:model.lazy="ldap_client_tls_cert" rows="10" class="form-control" placeholder="{{trans('general.example') .'-----BEGIN CERTIFICATE-----'."\r\n1234567890\r\n-----END CERTIFICATE-----"}}">
                                {{old('ldap_client_tls_cert', $ldap_client_tls_cert)}}</textarea><p class="text-warning">
                                        <p class="help-block">{{ trans('admin/settings/general.ldap_client_tls_cert_help') }}</p>
                                        {!! $errors->first('ldap_client_tls_cert', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @endif
                                </div>
                            </div><!-- LDAP Client-Side TLS certificate -->
                            <!-- LDAP Server -->
                            <div class="form-group {{ $errors->has('ldap_server') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_server', trans('admin/settings/general.ldap_server')) }}
                                </div>
                                <div class="col-md-9">
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_server" type="text" class="form-control" value="{{old('ldap_server', $ldap_server)}}" placeholder="{{trans('general.example') .'ldap://ldap.example.com'}} " disabled>
                                        <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                    @else
                                        <input  wire:model.lazy="ldap_server" type="text" class="form-control" value="{{old('ldap_server', $ldap_server)}}" placeholder="{{trans('general.example') .'ldap://ldap.example.com'}}">
                                        <p class="help-block">{{ trans('admin/settings/general.ldap_server_help') }}</p>
                                        {!! $errors->first('ldap_server', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @endif
                                </div>
                            </div><!-- LDAP Server -->

                            <!-- Start TLS -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_tls', trans('admin/settings/general.ldap_tls')) }}
                                </div>
                                <div class="col-md-9">
                                    <label class="form-control">
                                        <input wire:model="ldap_tls" type="checkbox" class="minimal" value="{{old('ldap_tls', $ldap_tls) }}">
                                        {{ trans('admin/settings/general.ldap_tls_help') }}
                                        {!! $errors->first('ldap_tls', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                        @if (config('app.lock_passwords')===true)
                                            <input wire:model="ldap_tls" type="checkbox" class="minimal" value="{{old('ldap_tls', $ldap_tls) }}"   disabled>
                                            <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                        @endif
                                    </label>
                                </div>
                            </div>

                            <!-- Ignore LDAP Certificate -->
                            <div class="form-group {{ $errors->has('ldap_server_cert_ignore') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_server_cert_ignore', trans('admin/settings/general.ldap_server_cert')) }}
                                </div>
                                <div class="col-md-9">
                                    <label class="form-control">
                                        <input wire:model="ldap_server_cert_ignore" type="checkbox" class="minimal" value="{{old('ldap_server_cert_ignore', $ldap_server_cert_ignore) }}">
                                        {{ trans('admin/settings/general.ldap_server_cert_ignore') }}
                                        {!! $errors->first('ldap_server_cert_ignore', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                        @if (config('app.lock_passwords')===true)
                                            <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                        @endif
                                    </label>
                                    <p class="help-block">{{ trans('admin/settings/general.ldap_server_cert_help') }}</p>
                                </div>
                            </div>

                            <!-- LDAP Username -->
                            <div class="form-group {{ $errors->has('ldap_uname') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_uname', trans('admin/settings/general.ldap_uname')) }}
                                </div>
                                <div class="col-md-9">
                                    <input  wire:model.lazy="ldap_uname" type="text" class="form-control" value="{{old('ldap_uname', $ldap_uname)}}"  autocomplete="off" placeholder="{{trans('general.example') .'ldap://ldap.example.com'}} " >
                                    {!! $errors->first('ldap_uname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_uname" type="text" class="form-control" value="{{old('ldap_uname', $ldap_uname)}}" placeholder="{{trans('general.example') .'ldap://ldap.example.com'}} " disabled>
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
                                    <input  wire:model.lazy="ldap_pword" type="password" class="form-control hide-readonly"  autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                                    {!! $errors->first('ldap_pword', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_pword" type="password" class="form-control"  placeholder="{{trans('general.example') .'binduserpassword'}} " disabled>
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
                                    <input  wire:model.lazy="ldap_basedn" type="text" class="form-control" value="{{old('ldap_basedn', $ldap_basedn)}}" placeholder="{{trans('general.example') .'cn=users/authorized,dc=example,dc=com'}} " >
                                    {!! $errors->first('ldap_basedn', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_basedn" type="text" class="form-control" value="{{old('ldap_basedn', $ldap_basedn)}}" placeholder="{{trans('general.example') .'cn=users/authorized,dc=example,dc=com'}} " disabled>
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
                                    <input  wire:model.lazy="ldap_filter" type="text" class="form-control" value="{{old('ldap_filter', $ldap_filter)}}" placeholder="{{trans('general.example') .'&(cn=*)'}} ">
                                    {!! $errors->first('ldap_filter', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_filter" type="text" class="form-control" value="{{old('ldap_filter', $ldap_filter)}}" placeholder="{{trans('general.example') .'&(cn=*)'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_username_field" type="text" class="form-control" value="{{old('ldap_filter',$ldap_username_field)}}" placeholder="{{trans('general.example') .'samaccountname'}} ">
                                    {!! $errors->first('ldap_username_field', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_username_field" type="text" class="form-control" value="{{old('ldap_filter',$ldap_username_field)}}" placeholder="{{trans('general.example') .'samaccountname'}} " disabled>
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
                                    <input  wire:model.lazy="ldap_lname_field" type="text" class="form-control" value="{{old('ldap_filter',$ldap_lname_field)}}" placeholder="{{trans('general.example') .'sn'}} ">

                                    {!! $errors->first('ldap_lname_field', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_lname_field" type="text" class="form-control" value="{{old('ldap_filter',$ldap_lname_field)}}" placeholder="{{trans('general.example') .'sn'}} " disabled>

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
                                    <input  wire:model.lazy="ldap_fname_field" type="text" class="form-control" value="{{old('ldap_filter',$ldap_fname_field)}}" placeholder="{{trans('general.example') .'givenname'}}">
                                    {!! $errors->first('ldap_fname_field', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_fname_field" type="text" class="form-control" value="{{old('ldap_filter',$ldap_fname_field)}}" placeholder="{{trans('general.example') .'givenname'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_auth_filter_query" type="text" class="form-control" value="{{old('ldap_filter',$ldap_auth_filter_query)}}" placeholder="{{trans('general.example') .'uid='}}">
                                    {!! $errors->first('ldap_auth_filter_query', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_auth_filter_query" type="text" class="form-control" value="{{old('ldap_filter',$ldap_auth_filter_query)}}" placeholder="{{trans('general.example') .'uid='}}" disabled>
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
                                    <input  wire:model.lazy="ldap_version" type="text" class="form-control" value="{{old('ldap_filter',$ldap_version)}}" placeholder="{{trans('general.example') .'3'}}">
                                    {!! $errors->first('ldap_version', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_version" type="text" class="form-control" value="{{old('ldap_filter',$ldap_version)}}" placeholder="{{trans('general.example') .'3'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_active_flag" type="text" class="form-control" value="{{old('ldap_active_flag',$ldap_active_flag)}}">
                                    <p class="help-block">{!! trans('admin/settings/general.ldap_activated_flag_help') !!}</p>
                                    {!! $errors->first('ldap_active_flag', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_active_flag" type="text" class="form-control" value="{{old('ldap_active_flag',$ldap_active_flag)}}" disabled>
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
                                    <input  wire:model.lazy="ldap_emp_num" type="text" class="form-control" value="{{old('ldap_emp_num',$ldap_emp_num)}}" placeholder="{{trans('general.example') .'employeenumber/employeeid'}}">
                                    {!! $errors->first('ldap_emp_num', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_emp_num" type="text" class="form-control" value="{{old('ldap_emp_num',$ldap_emp_num)}}" placeholder="{{trans('general.example') .'employeenumber/employeeid'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_dept" type="text" class="form-control" value="{{old('ldap_dept',$ldap_dept)}}" placeholder="{{trans('general.example') .'department'}}">
                                    {!! $errors->first('ldap_dept', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_dept" type="text" class="form-control" value="{{old('ldap_dept',$ldap_dept)}}" placeholder="{{trans('general.example') .'department'}}" disabled>
                                        <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                    @endif
                                </div>
                            </div>
                            <!-- LDAP Manager -->
                            <div class="form-group {{ $errors->has('ldap_dept') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_manager', trans('admin/settings/general.ldap_manager')) }}
                                </div>
                                <div class="col-md-9">
                                    <input  wire:model.lazy="ldap_manager" type="text" class="form-control" value="{{old('ldap_dept',$ldap_manager)}}" placeholder="{{trans('general.example') .'manager'}}">
                                    {!! $errors->first('ldap_manager', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_manager" type="text" class="form-control" value="{{old('ldap_dept',$ldap_manager)}}" placeholder="{{trans('general.example') .'manager'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_email" type="text" class="form-control" value="{{old('ldap_email', $ldap_email)}}" placeholder="{{trans('general.example') .'mail'}}">
                                    {!! $errors->first('ldap_email', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_email" type="text" class="form-control" value="{{old('ldap_email', $ldap_email)}}" placeholder="{{trans('general.example') .'mail'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_phone_field" type="text" class="form-control" value="{{old('ldap_phone_field', $ldap_phone_field)}}" placeholder="{{trans('general.example') .'telephonenumber'}}">
                                    {!! $errors->first('ldap_phone', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_phone_field" type="text" class="form-control" value="{{old('ldap_phone_field', $ldap_phone_field)}}" placeholder="{{trans('general.example') .'telephonenumber'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_jobtitle" type="text" class="form-control" value="{{old('ldap_jobtitle', $ldap_jobtitle)}}" placeholder="{{trans('general.example') .'title'}}">
                                    {!! $errors->first('ldap_jobtitle', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_jobtitle" type="text" class="form-control" value="{{old('ldap_jobtitle', $ldap_jobtitle)}}" placeholder="{{trans('general.example') .'title'}}" disabled>
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
                                    <input  wire:model.lazy="ldap_country" type="text" class="form-control" value="{{old('ldap_country', $ldap_country)}}" placeholder="{{trans('general.example') .'c'}}">
                                    {!! $errors->first('ldap_country', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_country" type="text" class="form-control" value="{{old('ldap_country', $ldap_country)}}" placeholder="{{trans('general.example') .'c'}}" disabled>
                                        <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- LDAP Company -->
                            <div class="form-group {{ $errors->has('ldap_company') ? 'error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('ldap_company', trans('admin/settings/general.ldap_company')) }}
                                </div>
                                <div class="col-md-8">
                                    <input  wire:model.lazy="ldap_company" type="text" class="form-control" value="{{old('ldap_company', $ldap_company)}}" placeholder="{{trans('general.example') .'company'}}">
                                    {!! $errors->first('ldap_company', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    @if (config('app.lock_passwords')===true)
                                        <input  wire:model.lazy="ldap_company" type="text" class="form-control" value="{{old('ldap_company', $ldap_company)}}" placeholder="{{trans('general.example') .'company'}}" disabled>
                                        <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                    @endif
                                </div>
                            </div>
                            @if ($setting->ldap_enabled)

                                <form wire:submit.prevent="ldapsynctest">
                                    <!-- LDAP test -->
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            {{ Form::label('test_ldap_sync', 'Test LDAP Sync') }}
                                        </div>
                                        <div class="col-md-9" id="ldaptestrow">
                                            <button type='submit' wire:click.prevent="ldapsynctest" {{ $setting->demoMode }} class="btn btn-default btn-sm pull-left" id="ldapsynctest" style="margin-right: 10px;">{{ trans('admin/settings/general.ldap_test_sync') }}</button>
                                        </div>
                                        <div class="col-md-9 col-md-offset-3">
                                            @if(session()->has('sync_success'))
                                                <div class="alert alert-success fade in">
                                                    {{session('sync_success')}}
                                                </div>
                                            @endif
                                            @if(session()->has('sync_empty'))
                                                <div class="alert alert-warning fade in">
                                                    {{session('sync_empty')}}
                                                </div>
                                            @endif
                                            @if(session()->has('sync_bind_fail'))
                                                <div class="alert alert-danger fade in">
                                                    {{session('sync_bind_fail')}}
                                                </div>
                                            @endif
                                            @if(session()->has('unknown_sync_fail'))
                                                <div class="alert alert-danger fade in">
                                                    {{session('unknown_sync_fail')}}
                                                </div>
                                            @endif
                                        </div>
                                        @if(isset($ldap_sync_test_users))
                                            <div class="col-md-9 col-md-offset-3">

                                                <br>
                                                <div id="ldapad_test_results" class="well well-sm">
                                                    <table class="table table-bordered table-condensed" style="background-color: #fff">
                                                        <thead>
                                                        <tr>
                                                            <th>{{ trans('admin/settings/general.employee_number') }}</th>
                                                            <th>{{ trans('mail.username') }}</th>
                                                            <th>{{ trans('general.first_name') }}</th>
                                                            <th>{{ trans('general.last_name') }}</th>
                                                            <th>{{ trans('general.email') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($ldap_sync_test_users as $user)
                                                            <tr>
                                                                <td>{{$user->employee_number}}</td>
                                                                <td>{{$user->username}}</td>
                                                                <td>{{$user->firstname}}</td>
                                                                <td>{{$user->lastname}}</td>
                                                                <td>{{$user->email}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-9 col-md-offset-3">
                                            <p class="help-block">{{ trans('admin/settings/general.ldap_login_sync_help') }}</p>
                                            @if (config('app.lock_passwords')===true)
                                                <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                            @endif
                                        </div>

                                    </div>
                                </form>

                                <!-- LDAP Login test -->
                                <form wire:submit.prevent="ldaptestlogin">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            {{ Form::label('test_ldap_login', 'Test LDAP Login') }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" wire:model.defer="ldaptest_user" id="ldaptest_user" class="form-control" placeholder="LDAP username">
                                                    {!! $errors->first('ldaptest_user', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="password" wire:model.defer="ldaptest_password" id="ldaptest_password" class="form-control hide-readonly" placeholder="LDAP password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                                                    {!! $errors->first('ldaptest_password', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                                </div>
                                                <div class="col-md-3">
                                                    <a href="#"  wire:click.prevent="ldaptestlogin" {{ $setting->demoMode }} class="btn btn-default btn-sm" id="ldaptestlogin" style="margin-right: 10px;">{{ trans('admin/settings/general.ldap_test')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-md-offset-3">
                                            <span id="ldaptestloginicon"></span>
                                            @if(session()->has('success'))
                                                <div class="alert alert-success fade in">
                                                    {{session('success')}}
                                                </div>
                                            @endif
                                            @if(session()->has('bind_fail'))
                                                <div class="alert alert-danger fade in">
                                                    {{session('bind_fail')}}
                                                </div>
                                            @endif
                                            @if(session()->has('login_fail'))
                                                <div class="alert alert-danger fade in">
                                                    {{session('login_fail')}}
                                                </div>
                                            @endif
                                            @if(session()->has('bind_fail_general'))
                                                <div class="alert alert-danger fade in">
                                                    {{session('bind_fail_general')}}
                                                </div>
                                            @endif
                                            @if(session()->has('connection_fail'))
                                                <div class="alert alert-danger fade in">
                                                    {{session('connection_fail')}}
                                                </div>
                                            @endif
                                            <span id="ldaptestloginstatus"></span>
                                        </div>
                                        <div class="col-md-9 col-md-offset-3">
                                            <p class="help-block">{{ trans('admin/settings/general.ldap_login_test_help') }}</p>
                                        </div>

                                    </div>
                                </form>


                                <!-- LDAP Forgotten password -->
                                <div class="form-group {{ $errors->has('custom_forgot_pass_url') ? 'error' : '' }}">
                                    <div class="col-md-3">
                                        {{ Form::label('custom_forgot_pass_url', trans('admin/settings/general.custom_forgot_pass_url')) }}
                                    </div>
                                    <div class="col-md-9">
                                        <input  wire:model.lazy="custom_forgot_pass_url" type="text" class="form-control" value="{{old('custom_forgot_pass_url', $custom_forgot_pass_url)}}" placeholder="{{trans('general.example') .' https://my.ldapserver-forgotpass.com'}}">
                                        <p class="help-block">{{ trans('admin/settings/general.custom_forgot_pass_url_help') }}</p>
                                        {!! $errors->first('custom_forgot_pass_url', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                        @if (config('app.lock_passwords')===true)
                                            <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                        @endif
                                    </div>
                                </div>
                        </div>

                        @endif
                    </div><!--col-md-11 col-md-offset-1-->

                    <div class="box-footer" style="display: flex; justify-content:space-between;">
                        <div class="text-left pull-left col-md-4">
                            <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                        </div>
                        <div class="col-md-4">
                            @if(session()->has('saved'))
                                <div class="alert alert-success fade in" style="text-align:center; height:35px; margin: auto;">
                                    <div style="margin-top:-8px;">
                                        <button type="button" class="close" data-dismiss="alert" style="margin-top:-3px;">×</button>
                                        {{ session('saved') }}
                                    </div>

                                </div>
                            @endif
                        </div>
                        <div class="text-right  col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                        </div>

                    </div><!--footer-->

                </div> <!--box-->
            </div><!--/.col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2-->
        </div><!--row-->
    </form>
</div>