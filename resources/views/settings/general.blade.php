@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.general_title') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')





    <form method="POST" autocomplete="off" class="form-horizontal" role="form" id="create-form">
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <x-icon type="general-settings"/>
                        {{ trans('admin/settings/general.general_settings') }}
                    </h2>
                </div>

               <div class="box-body">

                   <div class="col-md-12">

                    <!-- Full Multiple Companies Support -->
                    <div class="form-group {{ $errors->has('full_multiple_companies_support') ? 'error' : '' }}">
                        <div class="col-md-3">
                            <strong>{{ trans('admin/settings/general.full_multiple_companies_support_text') }}</strong>
                        </div>
                        <div class="col-md-9">
                            <label class="form-control">
                                {{ Form::checkbox('full_multiple_companies_support', '1', old('full_multiple_companies_support', $setting->full_multiple_companies_support),array('aria-label'=>'full_multiple_companies_support')) }}
                                {{ trans('admin/settings/general.full_multiple_companies_support_text') }}
                            </label>
                            {!! $errors->first('full_multiple_companies_support', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            <p class="help-block">
                                {{ trans('admin/settings/general.full_multiple_companies_support_help_text') }}
                            </p>
                        </div>
                    </div>

                    <!-- /.form-group -->

                    <!-- Require signature for acceptance -->
                    <div class="form-group {{ $errors->has('require_accept_signature') ? 'error' : '' }}">
                        <div class="col-md-3">
                           <strong> {{ trans('admin/settings/general.require_accept_signature') }}</strong>
                        </div>
                        <div class="col-md-9">
                            <label class="form-control">
                                {{ Form::checkbox('require_accept_signature', '1', old('require_accept_signature', $setting->require_accept_signature)) }}
                                {{ trans('general.yes') }}
                            </label>
                            {!! $errors->first('require_accept_signature', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            <p class="help-block">{{ trans('admin/settings/general.require_accept_signature_help_text') }}</p>
                        </div>
                    </div>
                    <!-- /.form-group -->


                    <!-- Email domain -->
                    <div class="form-group {{ $errors->has('email_domain') ? 'error' : '' }}">
                        <div class="col-md-3">
                            {{ Form::label('email_domain', trans('general.email_domain')) }}
                        </div>
                        <div class="col-md-9">
                            {{ Form::text('email_domain', old('email_domain', $setting->email_domain), array('class' => 'form-control','placeholder' => 'example.com')) }}
                            <span class="help-block">{{ trans('general.email_domain_help')  }}</span>
                            {!! $errors->first('email_domain', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                        </div>
                    </div>


                    <!-- Email format -->
                    <div class="form-group {{ $errors->has('email_format') ? 'error' : '' }}">
                        <div class="col-md-3">
                            {{ Form::label('email_format', trans('general.email_format')) }}
                        </div>
                        <div class="col-md-9">
                            {!! Form::username_format('email_format', old('email_format', $setting->email_format), 'select2') !!}
                            {!! $errors->first('email_format', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Username format -->
                    <div class="form-group {{ $errors->has('username_format') ? 'error' : '' }}">
                        <div class="col-md-3">
                            {{ Form::label('username_format', trans('general.username_format')) }}
                        </div>
                        <div class="col-md-9">
                            {!! Form::username_format('username_format', old('username_format', $setting->username_format), 'select2') !!}
                            {!! $errors->first('username_format', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}

                            <p class="help-block">
                                {{ trans('admin/settings/general.username_format_help') }}
                            </p>
                        </div>
                    </div>

                       <!-- user profile edit checkbox -->
                       <div class="form-group">
                           <div class="col-md-3">
                               <label>
                                   {{ trans('admin/settings/general.profile_edit') }}
                               </label>
                           </div>
                           <div class="col-md-8">
                               <label class="form-control">
                                   <input type="checkbox" value="1" name="profile_edit" {{ (old('profile_edit', $setting->profile_edit)) == '1' ? ' checked="checked"' : '' }} aria-label="profile_edit">
                                   {{ trans('admin/settings/general.profile_edit_help') }}
                               </label>

                           </div>
                       </div>

                       <!-- Load images in emails -->
                       <div class="form-group {{ $errors->has('show_images_in_email') ? 'error' : '' }}">
                           <div class="col-md-3">
                               <strong>{{ trans('admin/settings/general.show_images_in_email') }}</strong>
                           </div>
                           <div class="col-md-9">
                               <label class="form-control">
                                   {{ Form::checkbox('show_images_in_email', '1', old('show_images_in_email', $setting->show_images_in_email)) }}
                                   {{ trans('general.yes') }}
                                   {!! $errors->first('show_images_in_email', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                               </label>

                           </div>
                       </div>


                       <!-- unique serial -->
                       <div class="form-group">
                           <div class="col-md-3">
                               <strong>{{ trans('admin/settings/general.unique_serial') }}</strong>
                           </div>
                           <div class="col-md-9">
                               <label class="form-control">
                                   {{ Form::checkbox('unique_serial', '1', old('unique_serial', $setting->unique_serial),array('class' => 'minimal')) }}
                                   {{ trans('general.yes') }}
                                   {!! $errors->first('unique_serial', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                               </label>

                               <p class="help-block">
                               {{ trans('admin/settings/general.unique_serial_help_text') }}
                               </p>
                           </div>
                       </div>

                       <!-- Shortcuts enable -->
                       <div class="form-group {{ $errors->has('shortcuts_enabled') ? 'error' : '' }}">
                           <div class="col-md-3">
                               <strong> {{ trans('admin/settings/general.shortcuts_enabled') }}</strong>
                           </div>
                           <div class="col-md-9">
                               <label class="form-control">
                                   <input type="checkbox" name="shortcuts_enabled" value="1" {{ old('shortcuts_enabled', $setting->shortcuts_enabled) ? 'checked' : '' }}>
                                   {{ trans('general.yes') }}
                               </label>
                               {!! $errors->first('shortcuts_enabled', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                               <p class="help-block">{!!trans('admin/settings/general.shortcuts_help_text') !!}</p>
                           </div>
                       </div>


                       <!-- Per Page -->
                    <div class="form-group {{ $errors->has('per_page') ? 'error' : '' }}">
                        <div class="col-md-3">
                            {{ Form::label('per_page', trans('admin/settings/general.per_page')) }}
                        </div>
                        <div class="col-md-9">
                            {{ Form::text('per_page', old('per_page', $setting->per_page), array('class' => 'form-control','placeholder' => '5', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                            {!! $errors->first('per_page', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                        </div>
                    </div>

                   <!-- Thumb Size -->
                   <div class="form-group {{ $errors->has('thumbnail_max_h') ? 'error' : '' }}">
                       <div class="col-md-3">
                           {{ Form::label('thumbnail_max_h', trans('admin/settings/general.thumbnail_max_h')) }}
                       </div>
                       <div class="col-md-9">
                           {{ Form::text('thumbnail_max_h', old('thumbnail_max_h', $setting->thumbnail_max_h), array('class' => 'form-control','placeholder' => '50', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                           <p class="help-block">{{ trans('admin/settings/general.thumbnail_max_h_help') }}</p>
                           {!! $errors->first('thumbnail_max_h', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                       </div>
                   </div>

                    <!-- Default EULA -->
                   <div class="form-group {{ $errors->has('default_eula_text') ? 'error' : '' }}">
                       <div class="col-md-3">
                           {{ Form::label('default_eula_text', trans('admin/settings/general.default_eula_text')) }}
                       </div>
                       <div class="col-md-9">
                           {{ Form::textarea('default_eula_text', old('default_eula_text', $setting->default_eula_text), array('class' => 'form-control','placeholder' => 'Add your default EULA text')) }}
                           {!! $errors->first('default_eula_text', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                           <p class="help-block">{{ trans('admin/settings/general.default_eula_help_text') }}</p>
                           <p class="help-block">{!! trans('admin/settings/general.eula_markdown') !!}</p>
                       </div>
                   </div>

                   <!-- Require Notes on checkin/checkout checkbox -->
                   <div class="form-group">
                       <div class="col-md-3">
                           <label>
                               {{ trans('admin/settings/general.require_checkinout_notes') }}
                           </label>
                       </div>
                       <div class="col-md-8">
                           <label class="form-control">
                               <input type="checkbox" value="1" name="require_checkinout_notes" {{ (old('require_checkinout_notes', $setting->require_checkinout_notes)) == '1' ? ' checked="checked"' : '' }} aria-label="require_checkinout_notes">
                               {{ trans('general.yes') }}
                           </label>
                               <p class="help-block">{{ trans('admin/settings/general.require_checkinout_notes_help_text') }}</p>
                       </div>
                   </div>
                   <!-- /.form-group -->


                    <!-- login text -->
                    <div class="form-group {{ $errors->has('login_note') ? 'error' : '' }}">
                        <div class="col-md-3">
                            {{ Form::label('login_note', trans('admin/settings/general.login_note')) }}
                        </div>
                        <div class="col-md-9">
                            @if (config('app.lock_passwords'))

                                <textarea class="form-control disabled" name="login_note" placeholder="If you do not have a login or have found a device belonging to this company, please call technical support at 888-555-1212. Thank you." rows="2" aria-label="login_note" readonly>{{ old('login_note', $setting->login_note) }}</textarea>
                                {!! $errors->first('login_note', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                            @else
                                <textarea class="form-control" name="login_note" aria-label="login_note" placeholder="If you do not have a login or have found a device belonging to this company, please call technical support at 888-555-1212. Thank you." rows="2">{{ old('login_note', $setting->login_note) }}</textarea>
                                {!! $errors->first('login_note', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            @endif
                            <p class="help-block">{!!  trans('admin/settings/general.login_note_help') !!}</p>
                        </div>
                    </div>

                       <!-- Mail test -->
                       <div class="form-group">
                           <div class="col-md-3">
                               {{ Form::label('login_note', 'Test Mail') }}
                           </div>
                           <div class="col-md-9" id="mailtestrow">
                               <a class="btn btn-default btn-sm pull-left" id="mailtest" style="margin-right: 10px;">
                                   {{ trans('admin/settings/general.mail_test') }}</a>
                               <span id="mailtesticon"></span>
                               <span id="mailtestresult"></span>
                               <span id="mailteststatus"></span>
                           </div>
                           <div class="col-md-9 col-md-offset-3">
                               <div id="mailteststatus-error" class="text-danger"></div>
                           </div>
                           <div class="col-md-9 col-md-offset-3">
                               <div class="help-block">
                                   <p>{{ trans('admin/settings/general.mail_test_help', array('replyto' => config('mail.reply_to.address'))) }}</p>
                               </div>
                           </div>

                       </div>

                       <!-- dashboard text -->
                       <div class="form-group {{ $errors->has('dashboard_message') ? 'error' : '' }}">
                           <div class="col-md-3">
                               {{ Form::label('dashboard_message', trans('admin/settings/general.dashboard_message')) }}
                           </div>
                           <div class="col-md-9">
                               @if (config('app.lock_passwords'))

                                   <textarea class="form-control disabled" name="login_note" placeholder="If you do not have a login or have found a device belonging to this company, please call technical support at 888-555-1212. Thank you." rows="2" aria-label="dashboard_message" readonly>{{ old('dashboard_message', $setting->login_note) }}</textarea>
                                   {!! $errors->first('dashboard_message', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                   <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                               @else
                                   <textarea class="form-control" aria-label="dashboard_message" name="dashboard_message" rows="2">{{ old('login_note', $setting->dashboard_message) }}</textarea>
                                   {!! $errors->first('dashboard_message', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                               @endif
                               <p class="help-block">
                                   {{ trans('admin/settings/general.dashboard_message_help') }}
                                   {!!  trans('general.github_markdown') !!}</p>
                           </div>
                       </div>




                       <!-- Archived in List -->
                       <div class="form-group {{ $errors->has('show_archived_in_list') ? 'error' : '' }}">
                           <div class="col-md-3">
                               {{ Form::label('show_archived_in_list',
                                              trans('admin/settings/general.show_archived_in_list')) }}
                           </div>
                           <div class="col-md-9">

                                   <label class="form-control">
                                       {{ Form::checkbox('show_archived_in_list', '1', old('show_archived_in_list', $setting->show_archived_in_list),array('aria-label'=>'show_archived_in_list')) }}
                                       {{ trans('admin/settings/general.show_archived_in_list_text') }}
                                   </label>
                                   {!! $errors->first('show_archived_in_list', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                          </div>
                       </div>

                       <!-- Show assets assigned to user's assets -->
                       <div class="form-group {{ $errors->has('show_assigned_assets') ? 'error' : '' }}">
                           <div class="col-md-3">
                               {{ Form::label('show_assigned_assets',
                                              trans('admin/settings/general.show_assigned_assets')) }}
                           </div>
                           <div class="col-md-9">
                               <label class="form-control">
                               {{ Form::checkbox('show_assigned_assets', '1', old('show_assigned_assets', $setting->show_assigned_assets),array('class' => 'minimal')) }}
                               {{ trans('general.yes') }}
                               </label>
                               <p class="help-block">{{ trans('admin/settings/general.show_assigned_assets_help') }}</p>
                               {!! $errors->first('show_assigned_assets', '<span class="alert-msg">:message</span>') !!}
                           </div>
                       </div>

                       <!-- Model List prefs -->
                       <div class="form-group {{ $errors->has('show_in_model_list') ? 'error' : '' }}">
                           <div class="col-md-3">
                               <strong>{{ trans('admin/settings/general.show_in_model_list') }}</strong>
                           </div>
                           <div class="col-md-9">
                               <label class="form-control">
                               {{ Form::checkbox('show_in_model_list[]', 'image', old('show_in_model_list', $snipeSettings->modellistCheckedValue('image')),array('class' => 'minimal', 'aria-label'=>'show_in_model_list' )) }} {{ trans('general.image') }}
                               </label>
                               <label class="form-control">
                               {{ Form::checkbox('show_in_model_list[]', 'category', old('show_in_model_list', $snipeSettings->modellistCheckedValue('category')),array('class' => 'minimal', 'aria-label'=>'show_in_model_list' )) }} {{ trans('general.category') }}
                               </label>
                               <label class="form-control">
                               {{ Form::checkbox('show_in_model_list[]', 'manufacturer', old('show_in_model_list', $snipeSettings->modellistCheckedValue('manufacturer')),array('class' => 'minimal', 'aria-label'=>'show_in_model_list' )) }}  {{ trans('general.manufacturer') }} </label>
                               <label class="form-control">
                               {{ Form::checkbox('show_in_model_list[]', 'model_number', old('show_in_model_list', $snipeSettings->modellistCheckedValue('model_number')),array('class' => 'minimal', 'aria-label'=>'show_in_model_list' )) }} {{ trans('general.model_no') }}
                               </label>
                           </div>
                       </div>


                       <!-- dash chart -->
                       <div class="form-group {{ $errors->has('dash_chart_type') ? 'error' : '' }}">
                           <div class="col-md-3">
                               {{ Form::label('show_in_model_list',
                                              trans('general.pie_chart_type')) }}
                           </div>
                           <div class="col-md-9">
                               {{ Form::select('dash_chart_type', array(
                                   'name' => 'Status Label Name',
                                   'type' => 'Status Label Type'), old('dash_chart_type', $setting->dash_chart_type), ['class' =>'select2', 'style' => 'width: 80%']) }}
                           </div>
                       </div>

                       
                       <!-- Depreciation method -->
                       <div class="form-group {{ $errors->has('depreciation_method') ? 'error' : '' }}">
                           <div class="col-md-3">
                                {{ Form::label('depreciation_method', trans('Depreciation method')) }}
                           </div>
                           <div class="col-md-9">
                               {{ Form::select('depreciation_method', array(
                                    'default' => 'Linear (default)', 
                                    'half_1' => 'Half-year convention, always applied', 
                                    'half_2' => 'Half-year convention, applied with condition', 
                                ), old('username_format', $setting->depreciation_method), ['class' =>'select2', 'style' => 'width: 80%']) }}
                           </div>
                       </div>
                       <!-- /.form-group -->

                       <!-- Privacy Policy Footer-->
                       <div class="form-group {{ $errors->has('privacy_policy_link') ? 'error' : '' }}">
                           <div class="col-md-3">
                               {{ Form::label('privacy_policy_link', trans('admin/settings/general.privacy_policy_link')) }}
                           </div>
                           <div class="col-md-9">
                               @if (config('app.lock_passwords'))
                                   {{ Form::text('privacy_policy_link', old('privacy_policy_link', $setting->privacy_policy_link), array('class' => 'form-control disabled', 'disabled' => 'disabled')) }}
                               @else
                                   {{ Form::text('privacy_policy_link', old('privacy_policy_link', $setting->privacy_policy_link), array('class' => 'form-control')) }}

                               @endif


                               <span class="help-block">{{ trans('admin/settings/general.privacy_policy_link_help')  }}</span>
                               {!! $errors->first('privacy_policy_link', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}

                               @if (config('app.lock_passwords')===true)
                                   <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
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
                    <button type="submit" class="btn btn-primary"><x-icon type="checkmark" /> {{ trans('general.save') }}</button>
                </div>

            </div>
            </div>

        </div> <!-- /box -->
    </div> <!-- /.col-md-8-->


    {{ Form::close() }}

@stop

@section('moar_scripts')
    <!-- bootstrap color picker -->
    <script nonce="{{ csrf_token() }}">
        //color picker with addon
        $(".header-color").colorpicker();
        // toggle the disabled state of asset id prefix
        $('#auto_increment_assets').on('ifChecked', function(){
            $('#auto_increment_prefix').prop('disabled', false).focus();
        }).on('ifUnchecked', function(){
            $('#auto_increment_prefix').prop('disabled', true);
        });


        // Test Mail
        $("#mailtest").click(function(){
            $("#mailtestrow").removeClass('text-success');
            $("#mailtestrow").removeClass('text-danger');
            $("#mailtesticon").html('');
            $("#mailteststatus").html('');
            $('#mailteststatus-error').html('');
            $("#mailtesticon").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.mail.sending') }}');
            $.ajax({
                url: '{{ route('api.settings.mailtest') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                dataType: 'json',

                success: function (data) {
                    console.dir(data);
                    $("#mailtesticon").html('');
                    $("#mailteststatus").html('');
                    $('#mailteststatus-error').html('');
                    $("#mailteststatus").removeClass('text-danger');
                    $("#mailteststatus").addClass('text-success');
                    if (data.message) {
                        $("#mailteststatus").html('<i class="fas fa-check text-success"></i> ' + data.message);
                    } else {
                        $("#mailteststatus").html('<i class="fas fa-check text-success"></i> {{ trans('admin/settings/message.mail.success') }}');
                    }
                },

                error: function (data) {

                    $("#mailtesticon").html('');
                    $("#mailteststatus").html('');
                    $('#mailteststatus-error').html('');
                    $("#mailteststatus").removeClass('text-success');
                    $("#mailteststatus").addClass('text-danger');
                    $("#mailtesticon").html('<i class="fas fa-exclamation-triangle text-danger"></i>');
                    $('#mailteststatus').html('{{ trans('admin/settings/message.mail.error') }}');
                    if (data.responseJSON) {
                        if (data.responseJSON.messages) {
                            $('#mailteststatus-error').html('Error: ' + data.responseJSON.messages);
                        } else {
                            $('#mailteststatus-error').html('{{ trans('admin/settings/message.mail.additional') }}');
                        }
                    } else {
                        console.dir(data);
                    }

                }


            });
        });


    </script>
@stop
