@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update Microsoft Teams Settings
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
                        <i class="fa fa-windows"></i> Microsoft Teams
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

    {{Form::close()}}

@stop

@push('js')
    <script nonce="{{ csrf_token() }}">
        var fieldcheck = function (event) {
            
            if($('#msteams_endpoint').val() != "") {
                //enable test button *only* if field is filled in
                $('#msteamstestcontainer').fadeIn(500);
            } else {
                //otherwise it's hidden
                $('#msteamstestcontainer').fadeOut(500);
            }

            if(event) { //on 'initial load' we don't *have* an 'event', but in the regular keyup callback, we *do*. So this only fires on 'real' callback events, not on first load
                if($('#msteams_endpoint').val() == "") {
                    // if field is blank, the user may want to disable MS Teams integration; enable the Save button
                    $('#save_msteams').removeAttr('disabled');
                }
            }
            
        };

        fieldcheck(); //run our field-checker once on page-load to set the initial state correctly.

        $('input:text').keyup(fieldcheck); // if *any* text field changes, we recalculate button states

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
        
    </script>

@endpush
