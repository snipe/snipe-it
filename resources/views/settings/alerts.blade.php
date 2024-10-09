@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.alert_title') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>


    <form method="POST" action="{{ route('settings.alerts.save') }}" autocomplete="off" class="form-horizontal" role="form" id="create-form">

    <!-- CSRF Token -->
   {{ csrf_field() }}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <x-icon type="bell"/> {{ trans('admin/settings/general.alerts') }}
                    </h2>
                </div>
                <div class="box-body">


                    <div class="col-md-11 col-md-offset-1">

                        <!-- Alerts Enabled -->
                        <div class="form-group {{ $errors->has('alerts_enabled') ? 'error' : '' }}">
                            <div class="col-md-9 col-md-offset-3">
                                <label class="form-control">
                                    {{ Form::checkbox('alerts_enabled', '1', old('alerts_enabled', $setting->alerts_enabled)) }}
                                    {{  trans('admin/settings/general.alerts_enabled') }}
                                </label>
                            </div>
                        </div>

                        <!-- Menu Alerts Enabled -->
                        <div class="form-group {{ $errors->has('show_alerts_in_menu') ? 'error' : '' }}">
                            <div class="col-md-9 col-md-offset-3">
                                <label class="form-control">
                                    {{ Form::checkbox('show_alerts_in_menu', '1', old('show_alerts_in_menu', $setting->show_alerts_in_menu)) }}
                                    {{ trans('admin/settings/general.show_alerts_in_menu') }}
                                </label>
                            </div>
                        </div>



                        <!-- Alert Email -->
                        <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('alert_email', trans('admin/settings/general.alert_email')) }}
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="alert_email" value="{{ old('alert_email', $setting->alert_email) }}" class="form-control" placeholder="admin@yourcompany.com" maxlength="191">
                                {!! $errors->first('alert_email', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}
                                <p class="help-block">{{ trans('admin/settings/general.alert_email_help') }}</p>

                            </div>
                        </div>


                        <!-- Admin CC Email -->
                        <div class="form-group {{ $errors->has('admin_cc_email') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('admin_cc_email', trans('admin/settings/general.admin_cc_email')) }}
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="admin_cc_email" value="{{ old('admin_cc_email', $setting->admin_cc_email) }}" class="form-control" placeholder="admin@yourcompany.com" maxlength="191">
                                {!! $errors->first('admin_cc_email', '<span class="alert-msg" aria-hidden="true">:message</span><br>') !!}

                                <p class="help-block">{{ trans('admin/settings/general.admin_cc_email_help') }}</p>


                            </div>
                        </div>

                        <!-- Alert interval -->
                        <div class="form-group {{ $errors->has('alert_interval') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('alert_interval', trans('admin/settings/general.alert_interval')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('alert_interval', old('alert_interval', $setting->alert_interval), array('class' => 'form-control','placeholder' => '30', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                                {!! $errors->first('alert_interval', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Alert threshold -->
                        <div class="form-group {{ $errors->has('alert_threshold') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('alert_threshold', trans('admin/settings/general.alert_inv_threshold')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('alert_threshold', old('alert_threshold', $setting->alert_threshold), array('class' => 'form-control','placeholder' => '5', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                                {!! $errors->first('alert_threshold', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>


                        <!-- Alert interval -->
                        <div class="form-group {{ $errors->has('audit_interval') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('audit_interval', trans('admin/settings/general.audit_interval')) }}
                            </div>
                            <div class="input-group col-md-2">
                                {{ Form::text('audit_interval', old('audit_interval', $setting->audit_interval), array('class' => 'form-control','placeholder' => '12', 'maxlength'=>'3')) }}
                                <span class="input-group-addon">{{ trans('general.months') }}</span>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('audit_interval', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                <p class="help-block">{{ trans('admin/settings/general.audit_interval_help') }}</p>
                            </div>
                        </div>

                        <!-- Alert threshold -->
                        <div class="form-group {{ $errors->has('audit_warning_days') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('audit_warning_days', trans('admin/settings/general.audit_warning_days')) }}
                            </div>
                            <div class="input-group col-md-2">
                                {{ Form::text('audit_warning_days', old('audit_warning_days', $setting->audit_warning_days), array('class' => 'form-control','placeholder' => '14', 'maxlength'=>'3')) }}
                                <span class="input-group-addon">{{ trans('general.days') }}</span>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('audit_warning_days', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                <p class="help-block">{{ trans('admin/settings/general.audit_warning_days_help') }}</p>
                            </div>
                        </div>

                        <!-- Due for checkin days -->
                        <div class="form-group {{ $errors->has('due_checkin_days') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('due_checkin_days', trans('admin/settings/general.due_checkin_days')) }}
                            </div>
                            <div class="input-group col-md-2">
                                {{ Form::text('due_checkin_days', old('due_checkin_days', $setting->due_checkin_days), array('class' => 'form-control','placeholder' => '14', 'maxlength'=>'3')) }}
                                <span class="input-group-addon">{{ trans('general.days') }}</span>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('due_checkin_days', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                <p class="help-block">{{ trans('admin/settings/general.due_checkin_days_help') }}</p>
                            </div>
                        </div>

                    </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-primary"><x-icon type="checkmark" /> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop

