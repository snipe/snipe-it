@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.branding_title') }}
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


    {{ Form::open(['method' => 'POST', 'files' => true, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'create-form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fas fa-copyright"></i> {{ trans('admin/settings/general.brand') }}
                    </h2>
                </div>
                <div class="box-body">


                    <div class="col-md-12">

                        <!-- Site name -->
                        <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">

                            <div class="col-md-3">
                                {{ Form::label('site_name', trans('admin/settings/general.site_name')) }}
                            </div>
                            <div class="col-md-7 required">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::text('site_name', Request::old('site_name', $setting->site_name), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'Snipe-IT Asset Management')) }}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    {{ Form::text('site_name',
                                        Request::old('site_name', $setting->site_name), array('class' => 'form-control','placeholder' => 'Snipe-IT Asset Management', 'data-validation' => 'required')) }}
                                @endif
                                {!! $errors->first('site_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>



                        <!-- Branding -->
                        <div class="form-group {{ $errors->has('brand') ? 'error' : '' }}">
                            <div class="col-md-3">
                                 {{ Form::label('brand', trans('admin/settings/general.web_brand')) }}
                            </div>
                            <div class="col-md-9">
                                {!! Form::select('brand', array('1'=>'Text','2'=>'Logo','3'=>'Logo + Text'), old('brand', $setting->brand), array('class' => 'form-control select2', 'style'=>'width: 150px ;')) !!}
                                {!! $errors->first('brand', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Logo -->
                    @include('partials/forms/edit/uploadLogo', [
                        "logoVariable" => "logo",
                        "logoId" => "uploadLogo",
                        "logoLabel" => trans('admin/settings/general.logo'),
                        "logoClearVariable" => "clear_logo",
                        "helpBlock" => trans('general.logo_size') . trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                    ])

                    <!-- Email Logo -->
                    @include('partials/forms/edit/uploadLogo', [
                        "logoVariable" => "email_logo",
                        "logoId" => "uploadEmailLogo",
                        "logoLabel" => trans('admin/settings/general.email_logo'),
                        "logoClearVariable" => "clear_email_logo",
                        "helpBlock" => trans('admin/settings/general.email_logo_size') . trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                    ])

                    <!-- Label Logo -->
                    @include('partials/forms/edit/uploadLogo', [
                        "logoVariable" => "label_logo",
                        "logoId" => "uploadLabelLogo",
                        "logoLabel" => trans('admin/settings/general.label_logo'),
                        "logoClearVariable" => "clear_label_logo",
                        "helpBlock" => trans('admin/settings/general.label_logo_size') . trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                    ])

                    <!-- Favicon -->
                    @include('partials/forms/edit/uploadLogo', [
                        "logoVariable" => "favicon",
                        "logoId" => "uploadFavicon",
                        "logoLabel" => trans('admin/settings/general.favicon'),
                        "logoClearVariable" => "clear_favicon",
                        "helpBlock" => trans('admin/settings/general.favicon_size') .' '. trans('admin/settings/general.favicon_format'),
                        "allowedTypes" => "image/x-icon,image/gif,image/jpeg,image/png,image/svg,image/svg+xml,image/vnd.microsoft.icon",
                        "maxSize" => 20000
                    ])

                    <!-- Include logo in print assets -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('logo_print_assets', trans('admin/settings/general.logo_print_assets')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('logo_print_assets', '1', old('logo_print_assets', $setting->logo_print_assets),array('class' => 'minimal', 'aria-label'=>'logo_print_assets')) }}
                                {{ trans('admin/settings/general.logo_print_assets_help') }}

                            </div>
                        </div>


                        <!-- show urls in emails-->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('show_url_in_emails', trans('admin/settings/general.show_url_in_emails')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('show_url_in_emails', '1', old('show_url_in_emails', $setting->show_url_in_emails),array('class' => 'minimal', 'aria-label'=>'show_url_in_emails')) }}
                                {{ trans('general.yes') }}
                                <p class="help-block">{{ trans('admin/settings/general.show_url_in_emails_help_text') }}</p>
                            </div>
                        </div>

                        <!-- Header color -->
                        <div class="form-group {{ $errors->has('header_color') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('header_color', trans('admin/settings/general.header_color')) }}
                            </div>
                            <div class="col-md-2">
                                <div class="input-group header-color">
                                    {{ Form::text('header_color', old('header_color', $setting->header_color), array('class' => 'form-control', 'style' => 'width: 100px;','placeholder' => '#FF0000', 'aria-label'=>'header_color')) }}
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div><!-- /.input group -->
                                {!! $errors->first('header_color', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Skin -->
                        <div class="form-group {{ $errors->has('skin') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('skin', trans('general.skin')) }}
                            </div>
                            <div class="col-md-9">
                                {!! Form::skin('skin', old('skin', $setting->skin), 'select2') !!}
                                {!! $errors->first('skin', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Allow User Skin -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('allow_user_skin', trans('admin/settings/general.allow_user_skin')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::checkbox('allow_user_skin', '1', old('allow_user_skin', $setting->allow_user_skin),array('class' => 'minimal')) }}
                                {{ trans('general.yes') }}
                                <p class="help-block">{{ trans('admin/settings/general.allow_user_skin_help_text') }}</p>
                            </div>
                        </div>

                        <!-- Custom css -->
                        <div class="form-group {{ $errors->has('custom_css') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('custom_css', trans('admin/settings/general.custom_css')) }}
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::textarea('custom_css', old('custom_css', $setting->custom_css), array('class' => 'form-control','placeholder' => 'Add your custom CSS','disabled'=>'disabled', 'aria-label'=>'custom_css')) }}
                                    {!! $errors->first('custom_css', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    {{ Form::textarea('custom_css', old('custom_css', $setting->custom_css), array('class' => 'form-control','placeholder' => 'Add your custom CSS', 'aria-label'=>'custom_css')) }}
                                    {!! $errors->first('custom_css', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @endif
                                <p class="help-block">{!! trans('admin/settings/general.custom_css_help') !!}</p>
                            </div>
                        </div>


                        <!-- Support Footer -->
                        <div class="form-group {{ $errors->has('support_footer') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('support_footer', trans('admin/settings/general.support_footer')) }}
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {!! Form::select('support_footer', array('on'=>'Enabled','off'=>'Disabled','admin'=>'Superadmin Only'), Request::old('support_footer', $setting->support_footer), ['class' => 'form-control select2 disabled', 'style'=>'width: 150px ;', 'disabled' => 'disabled']) !!}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    {!! Form::select('support_footer', array('on'=>'Enabled','off'=>'Disabled','admin'=>'Superadmin Only'), Request::old('support_footer', $setting->support_footer), array('class' => 'form-control select2', 'style'=>'width: 150px ;')) !!}
                                @endif


                                {!! $errors->first('support_footer', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>


                        <!-- Version Footer -->
                        <div class="form-group {{ $errors->has('version_footer') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('version_footer', trans('admin/settings/general.version_footer')) }}
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {!! Form::select('version_footer', array('on'=>'Enabled','off'=>'Disabled','admin'=>'Superadmin Only'), Request::old('version_footer', $setting->version_footer), ['class' => 'form-control select2 disabled', 'style'=>'width: 150px ;', 'disabled' => 'disabled']) !!}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    {!! Form::select('version_footer', array('on'=>'Enabled','off'=>'Disabled','admin'=>'Superadmin Only'), Request::old('version_footer', $setting->version_footer), array('class' => 'form-control select2', 'style'=>'width: 150px ;')) !!}
                                @endif

                                <p class="help-block">{{ trans('admin/settings/general.version_footer_help') }}</p>
                                {!! $errors->first('version_footer', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Additional footer -->
                        <div class="form-group {{ $errors->has('footer_text') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('footer_text', trans('admin/settings/general.footer_text')) }}
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {{ Form::textarea('footer_text', Request::old('footer_text', $setting->footer_text), array('class' => 'form-control', 'rows' => '4', 'placeholder' => 'Optional footer text','disabled'=>'disabled')) }}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    {{ Form::textarea('footer_text', Request::old('footer_text', $setting->footer_text), array('class' => 'form-control','rows' => '4','placeholder' => 'Optional footer text')) }}
                                @endif
                                <p class="help-block">{!! trans('admin/settings/general.footer_text_help') !!}</p>
                                {!! $errors->first('footer_text', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}

                            </div>
                        </div>




                    </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

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
    </script>
@stop