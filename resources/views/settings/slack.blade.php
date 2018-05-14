@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update Slack Settings
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


    {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <i class="fa fa-slack"></i> Slack
                    </h4>
                </div>
                <div class="box-body">


                    <p style="border-bottom: 0px;">
                        {!! trans('admin/settings/general.slack_integration_help',array('slack_link' => 'https://my.slack.com/services/new/incoming-webhook')) !!}

                    @if (($setting->slack_channel=='') && ($setting->slack_endpoint==''))
                           {{ trans('admin/settings/general.slack_integration_help_button') }}
                    @endif
                    </p>


                    <div class="col-md-11 col-md-offset-1" style="border-top: 0px;">


                        <!-- slack endpoint -->
                        <div class="form-group {{ $errors->has('slack_endpoint') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('slack_endpoint', trans('admin/settings/general.slack_endpoint')) }}
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('slack_endpoint', Input::old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX')) }}
                                @else
                                    {{ Form::text('slack_endpoint', Input::old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX')) }}
                                @endif
                                {!! $errors->first('slack_endpoint', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- slack channel -->
                        <div class="form-group {{ $errors->has('slack_channel') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('slack_channel', trans('admin/settings/general.slack_channel')) }}
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('slack_channel', Input::old('slack_channel', $setting->slack_channel), array('class' => 'form-control','disabled'=>'disabled','placeholder' => '#IT-Ops')) }}
                                @else
                                    {{ Form::text('slack_channel', Input::old('slack_channel', $setting->slack_channel), array('class' => 'form-control','placeholder' => '#IT-Ops')) }}
                                @endif
                                {!! $errors->first('slack_channel', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        <!-- slack botname -->
                        <div class="form-group {{ $errors->has('slack_botname') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('slack_botname', trans('admin/settings/general.slack_botname')) }}
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('slack_botname', Input::old('slack_botname', $setting->slack_botname), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'Snipe-Bot')) }}
                                @else
                                    {{ Form::text('slack_botname', Input::old('slack_botname', $setting->slack_botname), array('class' => 'form-control','placeholder' => 'Snipe-Bot')) }}
                                @endif
                                {!! $errors->first('slack_botname', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>

                        @if (($setting->slack_channel!='') && ($setting->slack_endpoint))
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('est_slack', 'Test Slack') }}
                            </div>
                            <div class="col-md-9" id="slacktestrow">
                                <a class="btn btn-default btn-sm pull-left" id="slacktest" style="margin-right: 10px;">Test <i class="fa fa-slack"></i> Integration</a>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                <span id="slacktesticon"></span>
                                <span id="slacktestresult"></span>
                                <span id="slackteststatus"></span>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                <p class="help-block">{{ trans('admin/settings/general.slack_test_help') }}</p>
                            </div>

                        </div>
                         @endif
                    </div> <!--/-->
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

@section('moar_scripts')
    <script nonce="{{ csrf_token() }}">
        $("#slacktest").click(function() {
            $("#slacktestrow").removeClass('text-success');
            $("#slacktestrow").removeClass('text-danger');
            $("#slackteststatus").removeClass('text-danger');
            $("#slackteststatus").html('');
            $("#slacktesticon").html('<i class="fa fa-spinner spin"></i> Sending Slack test message...');
            $.ajax({
                url: '{{ route('api.settings.slacktest') }}',
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
                    $("#slacktesticon").html('');
                    $("#slacktestrow").addClass('text-success');
                    $("#slackteststatus").addClass('text-success');
                    $("#slackteststatus").html('<i class="fa fa-check text-success"></i> Success! Check the {{ $setting->slack_channel}} channel for your test message');
                },

                error: function (data) {

                    if (data.responseJSON) {
                        var errors = data.responseJSON.message;
                    } else {
                        var errors;
                    }

                    var error_text = '';

                    $("#slacktesticon").html('');
                    $("#slackteststatus").addClass('text-danger');
                    $("#slacktesticon").html('<i class="fa fa-exclamation-triangle text-danger"></i>');

                    if (data.status == 500) {
                        $('#slackteststatus').html('500 Server Error');
                    } else if (data.status == 400) {

                        if (typeof errors != 'string') {

                            for (i = 0; i < errors.length; i++) {
                                if (errors[i]) {
                                    error_text += '<li>Error: ' + errors[i];
                                }

                            }

                        } else {
                            error_text = errors;
                        }

                        $('#slackteststatus').html(error_text);

                    } else {
                        $('#slackteststatus').html(data.responseText.message);
                    }
                }


            });
        });

    </script>

@stop
