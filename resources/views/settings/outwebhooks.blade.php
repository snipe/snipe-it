@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.outwebhooks_title') }}
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

    <!-- Slack -->

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

    <!-- MS Teams -->
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fab fa-windows"></i> Microsoft Teams
                    </h2>
                </div>
                <div class="box-body">


                    <p style="padding: 20px;">
                        {!! trans('admin/settings/general.msteams_integration_help',array('msteams_link' => 'https://docs.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook#create-incoming-webhook-1')) !!}

                    @if ($setting->msteams_endpoint=='')
                           {{ trans('admin/settings/general.msteams_integration_help_button') }}
                    @endif
                    </p>


                    <div class="col-md-12" style="border-top: 0px;">


                        <!-- MS Teams endpoint -->
                        <div class="form-group required {{ $errors->has('msteams_endpoint') ? 'error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('msteams_endpoint', trans('admin/settings/general.msteams_endpoint')) }}
                            </div>
                            <div class="col-md-10">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('msteams_endpoint', old('msteams_endpoint', $setting->msteams_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://organization.webhook.office.com/webhookXX/XXXXXXXXXXXXXXX', 'id' => 'msteams_endpoint')) }}
                                    <p class="text-warning"><i class="fa fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                                @else
                                    {{ Form::text('msteams_endpoint', old('msteams_endpoint', $setting->msteams_endpoint), array('class' => 'form-control','placeholder' => 'https://organization.webhook.office.com/webhookXX/XXXXXXXXXXXXXXX', 'id' => 'msteams_endpoint')) }}
                                @endif
                                {!! $errors->first('msteams_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>


                       <div class="form-group" id="msteamstestcontainer" style="display: none">
                           
                            <div class="col-md-2">
                                {{ Form::label('test_msteams', 'Test Microsoft Teams') }}
                            </div>
                            <div class="col-md-10" id="msteamstestrow">
                                <a class="btn btn-default btn-sm pull-left" id="msteamstest" style="margin-right: 10px;">Test <i class="fab fa-windows"></i> Integration</a>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <span id="msteamstesticon"></span>
                                <span id="msteamstestresult"></span>
                                <span id="msteamsteststatus"></span>
                            </div>


                        </div>
                    </div> <!--/-->
                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" id="save_msteams" class="btn btn-primary" disabled><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    <!-- Discord -->
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fab fa-discord"></i> Discord
                    </h2>
                </div>
                <div class="box-body">


                    <p style="padding: 20px;">
                        {!! trans('admin/settings/general.discord_integration_help',array('discord_link' => 'https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks')) !!}

                    @if ($setting->discord_endpoint=='')
                           {{ trans('admin/settings/general.discord_integration_help_button') }}
                    @endif
                    </p>


                    <div class="col-md-12" style="border-top: 0px;">


                        <!-- Discord endpoint -->
                        <div class="form-group required {{ $errors->has('discord_endpoint') ? 'error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('discord_endpoint', trans('admin/settings/general.discord_endpoint')) }}
                            </div>
                            <div class="col-md-10">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('discord_endpoint', old('discord_endpoint', $setting->discord_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://discord.com/api/webhooks/XXXXXXXXXXX/XXXXXXXXXXXXXXXXXX', 'id' => 'discord_endpoint')) }}
                                    <p class="text-warning"><i class="fa fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                                @else
                                    {{ Form::text('discord_endpoint', old('discord_endpoint', $setting->discord_endpoint), array('class' => 'form-control','placeholder' => 'https://discord.com/api/webhooks/XXXXXXXXXXX/XXXXXXXXXXXXXXXXXX', 'id' => 'discord_endpoint')) }}
                                @endif
                                {!! $errors->first('discord_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>
                        <!-- Discord botname -->
                        <div class="form-group required {{ $errors->has('discord_botname') ? 'error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('discord_botname', trans('admin/settings/general.discord_botname')) }}
                            </div>
                            <div class="col-md-10">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('discord_botname', old('discord_botname', $setting->discord_botname), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'Snipe-Bot')) }}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                                @else
                                    {{ Form::text('discord_botname', old('discord_botname', $setting->discord_botname), array('class' => 'form-control','placeholder' => 'Snipe-Bot')) }}
                                @endif
                                {!! $errors->first('discord_botname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                       <div class="form-group" id="discordtestcontainer" style="display: none">
                           
                            <div class="col-md-2">
                                {{ Form::label('test_discord', 'Test Discord') }}
                            </div>
                            <div class="col-md-10" id="discordtestrow">
                                <a class="btn btn-default btn-sm pull-left" id="discordtest" style="margin-right: 10px;">Test <i class="fab fa-discord"></i> Integration</a>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <span id="discordtesticon"></span>
                                <span id="discordtestresult"></span>
                                <span id="discordteststatus"></span>
                            </div>


                        </div>
                    </div> <!--/-->
                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" id="save_discord" class="btn btn-primary" disabled><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    <!-- webhook -->
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fas fa-link"></i> webhook
                    </h2>
                </div>
                <div class="box-body">


                    <p style="padding: 20px;">
                        {!! trans('admin/settings/general.webhook_integration_help',array('webhook_link' => 'https://google.com')) !!}

                    @if ($setting->webhook_endpoint=='')
                           {{ trans('admin/settings/general.webhook_integration_help_button') }}
                    @endif
                    </p>


                    <div class="col-md-12" style="border-top: 0px;">


                        <!-- webhook endpoint -->
                        <div class="form-group required {{ $errors->has('webhook_endpoint') ? 'error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('webhook_endpoint', trans('admin/settings/general.webhook_endpoint')) }}
                            </div>
                            <div class="col-md-10">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('webhook_endpoint', old('webhook_endpoint', $setting->webhook_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://webhook.com/api/webhooks/XXXXXXXXXXX/XXXXXXXXXXXXXXXXXX', 'id' => 'webhook_endpoint')) }}
                                    <p class="text-warning"><i class="fa fa-lock"></i> {{ trans('general.feature_disabled') }}</p>

                                @else
                                    {{ Form::text('webhook_endpoint', old('webhook_endpoint', $setting->webhook_endpoint), array('class' => 'form-control','placeholder' => 'https://webhook.com/api/webhooks/XXXXXXXXXXX/XXXXXXXXXXXXXXXXXX', 'id' => 'webhook_endpoint')) }}
                                @endif
                                {!! $errors->first('webhook_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>


                       <div class="form-group" id="webhooktestcontainer" style="display: none">
                           
                            <div class="col-md-2">
                                {{ Form::label('test_webhook', 'Test webhook') }}
                            </div>
                            <div class="col-md-10" id="webhooktestrow">
                                <a class="btn btn-default btn-sm pull-left" id="webhooktest" style="margin-right: 10px;">Test <i class="fas fa-link"></i> Integration</a>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <span id="webhooktesticon"></span>
                                <span id="webhooktestresult"></span>
                                <span id="webhookteststatus"></span>
                            </div>


                        </div>
                    </div> <!--/-->
                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" id="save_webhook" class="btn btn-primary" disabled><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
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
            //slack field check
            if($('#slack_endpoint').val() != "" && $('#slack_channel').val() != "" && $('#slack_botname').val() != "") {
                //enable test button *only* if all three fields are filled in
                $('#slacktestcontainer').fadeIn(500);
            } else {
                //otherwise it's hidden
                $('#slacktestcontainer').fadeOut(500);
            }

            //msteams field check
            if($('#msteams_endpoint').val() != "") {
                //enable test button *only* if field is filled in
                $('#msteamstestcontainer').fadeIn(500);
            } else {
                //otherwise it's hidden
                $('#msteamstestcontainer').fadeOut(500);
            }

            
            //discord field check
            if($('#discord_endpoint').val() != "" && $('#discord_botname').val() != "") {
                //enable test button *only* if field is filled in
                $('#discordtestcontainer').fadeIn(500);
            } else {
                //otherwise it's hidden
                $('#discordtestcontainer').fadeOut(500);
            }

            
            //webhook field check
            if($('#webhook_endpoint').val() != "") {
                //enable test button *only* if field is filled in
                $('#webhooktestcontainer').fadeIn(500);
            } else {
                //otherwise it's hidden
                $('#webhooktestcontainer').fadeOut(500);
            }

            if(event) { //on 'initial load' we don't *have* an 'event', but in the regular keyup callback, we *do*. So this only fires on 'real' callback events, not on first load
                
                //initial load enable/disable Slack
                if($('#slack_endpoint').val() == "" && $('#slack_channel').val() == "" && $('#slack_botname').val() == "") {
                    // if all three fields are blank, the user may want to disable Slack integration; enable the Save button
                    $('#save_slack').removeAttr('disabled');
                }
                //initial load enable/disable MS Teams
                if($('#msteams_endpoint').val() == "") {
                    // if field is blank, the user may want to disable MS Teams integration; enable the Save button
                    $('#save_msteams').removeAttr('disabled');
                }

                 //initial load enable/disable Discord
                 if($('#discord_endpoint').val() == "" && $('#discord_botname').val() == "") {
                    // if field is blank, the user may want to disable MS Teams integration; enable the Save button
                    $('#save_discord').removeAttr('disabled');
                }

                 //initial load enable/disable webhook
                 if($('#webhook_endpoint').val() == "") {
                    // if field is blank, the user may want to disable MS Teams integration; enable the Save button
                    $('#save_webhook').removeAttr('disabled');
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

    //ms teams
         $("#msteamstest").click(function() {

            $("#msteamstestrow").removeClass('text-success');
            $("#msteamstestrow").removeClass('text-danger');
            $("#msteamsteststatus").removeClass('text-danger');
            $("#msteamsteststatus").html('');
            $("#msteamstesticon").html('<i class="fa fa-spinner spin"></i> Sending Microsoft Teams test message...');
            $.ajax({
                url: '{{ route('api.settings.msteamstest') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'msteams_endpoint': $('#msteams_endpoint').val()

                },

                dataType: 'json',

                success: function (data) {
                    $('#save_msteams').removeAttr('disabled');
                    $("#msteamstesticon").html('');
                    $("#msteamstestrow").addClass('text-success');
                    $("#msteamsteststatus").addClass('text-success');
                    $("#msteamsteststatus").html('<i class="fa fa-check text-success"></i> Success! Check the channel for your test message, and be sure to click SAVE below to store your settings.');
                },

                error: function (data) {


                    if (data.responseJSON) {
                        var errors = data.responseJSON.message;
                    } else {
                        var errors;
                    }

                    var error_text = '';

                    $('#save_msteams').attr("disabled", true);
                    $("#msteamstesticon").html('');
                    $("#msteamsteststatus").addClass('text-danger');
                    $("#msteamstesticon").html('<i class="fa fa-exclamation-triangle text-danger"></i>');

                    if (data.status == 500) {
                        $('#msteamsteststatus').html('500 Server Error');
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

                        $('#msteamsteststatus').html(error_text);

                    } else {
                        $('#msteamsteststatus').html(data.responseText.message);
                    }
                }


            });
            return false;
        });

        //discord 
        $("#discordtest").click(function() {
           
            $("#discordtestrow").removeClass('text-success');
            $("#discordtestrow").removeClass('text-danger');
            $("#discordteststatus").removeClass('text-danger');
            $("#discordteststatus").html('');
            $("#discordtesticon").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.discord.sending') }}');
            $.ajax({
               
               url: '{{ route('api.settings.discordtest') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    'discord_endpoint': $('#discord_endpoint').val(),
                    'discord_botname': $('#discord_botname').val(),

                },

                dataType: 'json',

                success: function (data) {
                    $('#save_discord').removeAttr('disabled');
                    $("#discordtesticon").html('');
                    $("#discordtestrow").addClass('text-success');
                    $("#discordteststatus").addClass('text-success');
                
                    $("#discordteststatus").html('<i class="fas fa-check text-success"></i> {{ trans('admin/settings/message.discord.success_pt1') }} ' + '{{ trans('admin/settings/message.discord.success_pt2') }}');
                },

                error: function (data) {


                    if (data.responseJSON) {
                        var errors = data.responseJSON.errors;
                      
                    } else {
                        var errors;
                    }

                    var error_text = '';

                    $('#save_discord').attr("disabled", true);
                    $("#discordtesticon").html('');
                    $("#discordteststatus").addClass('text-danger');
                    $("#discordtesticon").html('<i class="fas fa-exclamation-triangle text-danger"></i><span class="text-danger">' + error_msg+ '</span>');

                    
                    if (data.status == 500) {
                        $('#discordteststatus').html('{{  trans('admin/settings/message.discord.500') }}');
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

                        $('#discordteststatus').html(error_text);

                    } else {
                        $('#discordteststatus').html(data.responseText.message);
                    }
                }


            });
            return false;
        });
        
        //webhook 
        $("#webhooktest").click(function() {
            
            $("#webhooktestrow").removeClass('text-success');
            $("#webhooktestrow").removeClass('text-danger');
            $("#webhookteststatus").removeClass('text-danger');
            $("#webhookteststatus").html('');
            $("#webhooktesticon").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.webhook.sending') }}');
            $.ajax({
                
                url: '{{ route('api.settings.webhooktest') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    'webhook_endpoint': $('#webhook_endpoint').val(),

                },

                dataType: 'json',

                success: function (data) {
                    $('#save_webhook').removeAttr('disabled');
                    $("#webhooktesticon").html('');
                    $("#webhooktestrow").addClass('text-success');
                    $("#webhookteststatus").addClass('text-success');
                
                    $("#webhookteststatus").html('<i class="fas fa-check text-success"></i> {{ trans('admin/settings/message.webhook.success_pt1') }} ' + '{{ trans('admin/settings/message.webhook.success_pt2') }}');
                },

                error: function (data) {


                    if (data.responseJSON) {
                        var errors = data.responseJSON.errors;
                        
                    } else {
                        var errors;
                    }

                    var error_text = '';

                    $('#save_webhook').attr("disabled", true);
                    $("#webhooktesticon").html('');
                    $("#webhookteststatus").addClass('text-danger');
                    $("#webhooktesticon").html('<i class="fas fa-exclamation-triangle text-danger"></i><span class="text-danger">' + error_msg+ '</span>');

                    
                    if (data.status == 500) {
                        $('#webhookteststatus').html('{{  trans('admin/settings/message.webhook.500') }}');
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

                        $('#webhookteststatus').html(error_text);

                    } else {
                        $('#webhookteststatus').html(data.responseText.message);
                    }
                }


            });
            return false;
        });
    </script>

@endpush
