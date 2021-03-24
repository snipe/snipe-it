@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update Slack Settings
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


    {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fa fa-slack"></i> Slack
                    </h2>
                </div>
                <div class="box-body">


                    <p style="padding: 20px;">
                        {!! trans('admin/settings/general.slack_integration_help',array('slack_link' => 'https://my.slack.com/services/new/incoming-webhook')) !!}

                    @if (($setting->slack_channel=='') && ($setting->slack_endpoint==''))
                           {{ trans('admin/settings/general.slack_integration_help_button') }}
                    @endif
                    </p>


                    <div class="col-md-12" style="border-top: 0px;">


                        <!-- slack endpoint -->
                        <div class="form-group required {{ $errors->has('slack_endpoint') ? 'error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('slack_endpoint', trans('admin/settings/general.slack_endpoint')) }}
                            </div>
                            <div class="col-md-10">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}
                                    <p class="text-warning"><i class="fa fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                                @else
                                    {{ Form::text('slack_endpoint', old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX', 'id' => 'slack_endpoint')) }}
                                @endif
                                {!! $errors->first('slack_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- slack channel -->
                        <div class="form-group required {{ $errors->has('slack_channel') ? 'error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('slack_channel', trans('admin/settings/general.slack_channel')) }}
                            </div>
                            <div class="col-md-10">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('slack_channel', old('slack_channel', $setting->slack_channel), array('class' => 'form-control','disabled'=>'disabled','placeholder' => '#IT-Ops')) }}
                                    <p class="text-warning"><i class="fa fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                                @else
                                    {{ Form::text('slack_channel', old('slack_channel', $setting->slack_channel), array('class' => 'form-control','placeholder' => '#IT-Ops')) }}
                                @endif
                                {!! $errors->first('slack_channel', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- slack botname -->
                        <div class="form-group required {{ $errors->has('slack_botname') ? 'error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('slack_botname', trans('admin/settings/general.slack_botname')) }}
                            </div>
                            <div class="col-md-10">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('slack_botname', old('slack_botname', $setting->slack_botname), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'Snipe-Bot')) }}
                                    <p class="text-warning"><i class="fa fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                                @else
                                    {{ Form::text('slack_botname', old('slack_botname', $setting->slack_botname), array('class' => 'form-control','placeholder' => 'Snipe-Bot')) }}
                                @endif
                                {!! $errors->first('slack_botname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group" id="slacktestcontainer" style="display: none">
                            <div class="col-md-2">
                                {{ Form::label('test_slack', 'Test Slack') }}
                            </div>
                            <div class="col-md-10" id="slacktestrow">
                                <a class="btn btn-default btn-sm pull-left" id="slacktest" style="margin-right: 10px;">Test <i class="fa fa-slack"></i> Integration</a>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <span id="slacktesticon"></span>
                                <span id="slacktestresult"></span>
                                <span id="slackteststatus"></span>
                            </div>


                        </div>
                    </div> <!--/-->
                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" id="save_slack" class="btn btn-primary" disabled><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop

@push('js')
    <script nonce="{{ csrf_token() }}">
        var fieldcheck = function (event) {
            if($('#slack_endpoint').val() != "" && $('#slack_channel').val() != "" && $('#slack_botname').val() != "") {
                //enable test button *only* if all three fields are filled in
                $('#slacktestcontainer').fadeIn(500);
            } else {
                //otherwise it's hidden
                $('#slacktestcontainer').fadeOut(500);
            }

            if(event) { //on 'initial load' we don't *have* an 'event', but in the regular keyup callback, we *do*. So this only fires on 'real' callback events, not on first load
                if($('#slack_endpoint').val() == "" && $('#slack_channel').val() == "" && $('#slack_botname').val() == "") {
                    // if all three fields are blank, the user may want to disable Slack integration; enable the Save button
                    $('#save_slack').removeAttr('disabled');
                }
            }
        };

        fieldcheck(); //run our field-checker once on page-load to set the initial state correctly.

        $('input:text').keyup(fieldcheck); // if *any* text field changes, we recalculate button states


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
                    'slack_endpoint': $('#slack_endpoint').val(),
                    'slack_channel': $('#slack_channel').val(),
                    'slack_botname': $('#slack_botname').val(),

                },

                dataType: 'json',

                success: function (data) {
                    $('#save_slack').removeAttr('disabled');
                    $("#slacktesticon").html('');
                    $("#slacktestrow").addClass('text-success');
                    $("#slackteststatus").addClass('text-success');
                    $("#slackteststatus").html('<i class="fa fa-check text-success"></i> Success! Check the ' + $('#slack_channel').val() + ' channel for your test message, and be sure to click SAVE below to store your settings.');
                },

                error: function (data) {


                    if (data.responseJSON) {
                        var errors = data.responseJSON.message;
                    } else {
                        var errors;
                    }

                    var error_text = '';

                    $('#save_slack').attr("disabled", true);
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
            return false;
        });

    </script>

@endpush
