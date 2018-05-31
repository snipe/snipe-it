@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update Security Settings
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')



    {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <i class="fa fa-lock"></i> Security
                    </h4>
                </div>
                <div class="box-body">


                    <div class="col-md-11 col-md-offset-1">


                        <!-- Two Factor -->
                        <div class="form-group {{ $errors->has('brand') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('two_factor_enabled', trans('admin/settings/general.two_factor_enabled_text')) }}
                            </div>
                            <div class="col-md-9">

                                {!! Form::two_factor_options('two_factor_enabled', Input::old('two_factor_enabled', $setting->two_factor_enabled), 'select2') !!}
                                <p class="help-block">{{ trans('admin/settings/general.two_factor_enabled_warning') }}</p>

                                @if (config('app.lock_passwords'))
                                    <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                                @endif

                                {!! $errors->first('two_factor_enabled', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Min characters -->
                        <div class="form-group {{ $errors->has('pwd_secure_min') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('pwd_secure_min', trans('admin/settings/general.pwd_secure_min')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('pwd_secure_min', Input::old('pwd_secure_min', $setting->pwd_secure_min), array('class' => 'form-control',  'style'=>'width: 50px;')) }}

                                {!! $errors->first('pwd_secure_min', '<span class="alert-msg">:message</span>') !!}
                                <p class="help-block">
                                    {{ trans('admin/settings/general.pwd_secure_min_help') }}
                                </p>


                            </div>
                        </div>


                        <!-- Common Passwords -->
                        <div class="form-group {{ $errors->has('pwd_secure_uncommon') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('pwd_secure_text',
                                              trans('admin/settings/general.pwd_secure_uncommon')) }}

                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('pwd_secure_uncommon', '1', Input::old('pwd_secure_uncommon', $setting->pwd_secure_uncommon),array('class' => 'minimal')) }}
                                {{ Form::label('pwd_secure_uncommon',  trans('general.yes')) }}
                                {!! $errors->first('pwd_secure_uncommon', '<span class="alert-msg">:message</span>') !!}
                                <p class="help-block">
                                    {{ trans('admin/settings/general.pwd_secure_uncommon_help') }}
                                </p>
                            </div>
                        </div>
                        <!-- /.form-group -->

                        <!-- Common Passwords -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('pwd_secure_complexity', trans('admin/settings/general.pwd_secure_complexity')) }}
                            </div>
                            <div class="col-md-9">

                                {{ Form::checkbox("pwd_secure_complexity['letters']", 'letters', Input::old('pwd_secure_uncommon', strpos($setting->pwd_secure_complexity, 'letters')!==false), array('class' => 'minimal')) }}
                                Require at least one letter <br>

                                {{ Form::checkbox("pwd_secure_complexity['numbers']", 'numbers', Input::old('pwd_secure_uncommon', strpos($setting->pwd_secure_complexity, 'numbers')!==false), array('class' => 'minimal')) }}
                                Require at least one number<br>

                                {{ Form::checkbox("pwd_secure_complexity['symbols']", 'symbols', Input::old('pwd_secure_uncommon', strpos($setting->pwd_secure_complexity, 'symbols')!==false), array('class' => 'minimal')) }}
                                Require at least one symbol<br>

                                {{ Form::checkbox("pwd_secure_complexity['case_diff']", 'case_diff', Input::old('pwd_secure_uncommon', strpos($setting->pwd_secure_complexity, 'case_diff')!==false), array('class' => 'minimal')) }}
                                Require at least one uppercase and one lowercase

                                <p class="help-block">
                                    {{ trans('admin/settings/general.pwd_secure_complexity_help') }}
                                </p>
                            </div>
                        </div>
                        <!-- /.form-group -->
                        <hr>
                        <!-- Remote User Authentication -->
                        <div class="form-group {{ $errors->has('login_remote_user') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('login_remote_user', trans('admin/settings/general.login_remote_user_text')) }}
                            </div>
                            <div class="col-md-9">
                                <!--  Enable Remote User Login -->

                                @if (config('app.lock_passwords'))
                                    <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                                @else
                                    {{ Form::checkbox('login_remote_user_enabled', '1', Input::old('login_remote_user_enabled', $setting->login_remote_user_enabled),array('class' => 'minimal')) }}
                                    {{ Form::label('login_remote_user_enabled',  trans('admin/settings/general.login_remote_user_enabled_text')) }}
                                    {!! $errors->first('login_remote_user_enabled', '<span class="alert-msg">:message</span>') !!}
                                    <p class="help-block">
                                        {{ trans('admin/settings/general.login_remote_user_enabled_help') }}
                                    </p>
                                    <!-- Custom logout url to redirect to authentication provider -->
                                    {{ Form::label('login_remote_user_custom_logout_url',  trans('admin/settings/general.login_remote_user_custom_logout_url_text')) }}
                                    {{ Form::text('login_remote_user_custom_logout_url', Input::old('login_remote_user_custom_logout_url', $setting->login_remote_user_custom_logout_url),array('class' => 'form-control')) }}

                                    {!! $errors->first('login_remote_user_custom_logout_url', '<span class="alert-msg">:message</span>') !!}
                                    <p class="help-block">
                                        {{ trans('admin/settings/general.login_remote_user_custom_logout_url_help') }}
                                    </p>
                                    <!--  Disable other logins mechanism -->
                                    {{ Form::checkbox('login_common_disabled', '1', Input::old('login_common_disabled', $setting->login_common_disabled),array('class' => 'minimal')) }}
                                    {{ Form::label('login_common_disabled',  trans('admin/settings/general.login_common_disabled_text')) }}
                                    {!! $errors->first('login_common_disabled', '<span class="alert-msg">:message</span>') !!}
                                    <p class="help-block">
                                        {{ trans('admin/settings/general.login_common_disabled_help') }}
                                    </p>
                                @endif

                            </div>
                        </div>



                    </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop
