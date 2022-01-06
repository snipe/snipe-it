@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.slack_title') }}
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
                        <i class="fab fa-slack"></i> {{ trans('admin/settings/general.slack') }}
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
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

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
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

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
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

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
                                <a class="btn btn-default btn-sm pull-left" id="slacktest" style="margin-right: 10px;">{!! trans('admin/settings/general.slack_test') !!}</a>
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
                        <button type="submit" id="save_slack" class="btn btn-primary" disabled><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
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
            $("#slacktesticon").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.slack.sending') }}');
            $.ajax({
                
                // If I comment this back in, I always get a success (200) message
                // Without it, I get 
                    //  beforeSend: function (xhr) { 
                    //  xhr.setRequestHeader("Content-Type","application/json");
                    // xhr.setRequestHeader("Accept","text/json");
                    // },
            
                
                url: '{{ route('api.settings.slacktest') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                //    'Accept': 'application/json',
                //    'Content-Type': 'application/json',
                },
                data: {
                    'slack_endpoint': $('#slack_endpoint').val(),
                    'slack_channel': $('#slack_channel').val(),
                    'slack_botname': $('#slack_botname').val(),

                },

                dataType: 'json',

                accepts: {
                    text: "application/json"
                },

                success: function (data) {
                    $('#save_slack').removeAttr('disabled');
                    $("#slacktesticon").html('');
                    $("#slacktestrow").addClass('text-success');
                    $("#slackteststatus").addClass('text-success');
                    //TODO: This is a bit hacky...Might need some cleanup
                    $("#slackteststatus").html('<i class="fas fa-check text-success"></i> {{ trans('admin/settings/message.slack.success_pt1') }} ' + $('#slack_channel').val() + '{{ trans('admin/settings/message.slack.success_pt2') }}');
                },

                error: function (data) {


                    if (data.responseJSON) {
                        var errors = data.responseJSON.errors;
                        var error_msg = data.responseJSON.message;
                    } else {
                        var errors;
                        var error_msg = trans('admin/settings/message.slack.error');
                    }

                    var error_text = '';

                    $('#save_slack').attr("disabled", true);
                    $("#slacktesticon").html('');
                    $("#slackteststatus").addClass('text-danger');
                    $("#slacktesticon").html('<i class="fas fa-exclamation-triangle text-danger"></i><span class="text-danger">' + error_msg+ '</span>');

                    
                    if (data.status == 500) {
                        $('#slackteststatus').html('{{  trans('admin/settings/message.slack.500') }}');
                    } else if ((data.status == 400) || (data.status == 422)) {
                        console.log('Type of errors is '+ typeof errors);
                        console.log('Data status was 400 or 422');

                        if (typeof errors != 'string') {
                        
                            console.log(errors.length);

                            for (i in errors) {
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
