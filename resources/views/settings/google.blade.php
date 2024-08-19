@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.google_login') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
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
                    <h2 class="box-title">
                        <x-icon type="google"/>
                        {{ trans('admin/settings/general.google_login') }}
                    </h2>
                </div>
                <div class="box-body">


                    <div class="col-md-12">

                        <!-- Google Redirect URL -->
                        <div class="form-group">
                            <div class="col-md-3 text-right">
                                <strong>Redirect URL</strong>
                            </div>
                            <div class="col-md-8">
                                <p class="form-control-static" style="margin-top: -5px"><code>{{ config('app.url') }}/google/callback</code></p>
                                <p class="help-block">{!! trans('admin/settings/general.google_callback_help') !!}</p>
                            </div>
                        </div>


                        <!-- Google login -->
                        <div class="form-group {{ $errors->has('google') ? 'error' : '' }}">

                            <div class="col-md-8 col-md-offset-3">
                                <label class="form-control{{ (config('app.lock_passwords')===true) ? ' form-control--disabled': '' }}">
                                    <span class="sr-only">{{ trans('admin/settings/general.pwd_secure_uncommon') }}</span>
                                    {{ Form::checkbox('google_login', '1', old('google_login', $setting->google_login),array('aria-label'=>'google_login', (config('app.lock_passwords')===true) ? 'disabled': '')) }}
                                    {{ trans('admin/settings/general.enable_google_login') }}
                                </label>
                                <p class="help-block">{{ trans('admin/settings/general.enable_google_login_help') }}</p>
                            </div>
                        </div>


                        <!-- Google Client ID -->
                        <div class="form-group {{ $errors->has('google_client_id') ? 'error' : '' }}">
                            <div class="col-md-3 text-right">
                                {{ Form::label('google_client_id', 'Client ID') }}
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('google_client_id', old('google_client_id', $setting->google_client_id), ['class' => 'form-control','placeholder' => trans('general.example') .'000000000000-XXXXXXXXXXX.apps.googleusercontent.com', (config('app.lock_passwords')===true) ? 'disabled': '']) }}
                                {!! $errors->first('google_client_id', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Google Client Secret -->
                        <div class="form-group {{ $errors->has('google_client_secret') ? 'error' : '' }}">
                            <div class="col-md-3 text-right">
                                {{ Form::label('google_client_secret', 'Client Secret') }}
                            </div>
                            <div class="col-md-8">

                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('google_client_secret', 'XXXXXXXXXXXXXXXXXXXXXXX', ['class' => 'form-control', 'disabled']) }}
                                @else
                                    {{ Form::text('google_client_secret', old('google_client_secret', $setting->google_client_secret), ['class' => 'form-control','placeholder' => trans('general.example') .'XXXXXXXXXXXX']) }}
                                @endif

                                {!! $errors->first('google_client_secret', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock" aria-hidden="true"></i> {{ trans('general.feature_disabled') }}</p>
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
                        <button type="submit" class="btn btn-success"{{ (config('app.lock_passwords')===true) ? ' disabled': '' }}><x-icon type="checkmark" /> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop
