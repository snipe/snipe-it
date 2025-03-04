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


    <form
        method="POST"
        action="{{ route('settings.branding.save') }}"
        accept-charset="UTF-8"
        autocomplete="off"
        class="form-horizontal"
        role="form"
        id="create-form"
        enctype="multipart/form-data"
        novalidate="novalidate"
    >
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <x-icon type="branding"/>
                         {{ trans('admin/settings/general.brand') }}
                    </h2>
                </div>
                <div class="box-body">


                    <div class="col-md-12">

                        <!-- Site name -->
                        <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">

                            <div class="col-md-3">
                                <label for="site_name">{{ trans('admin/settings/general.site_name') }}</label>
                            </div>
                            <div class="col-md-7 required">
                                @if (config('app.lock_passwords')===true)
                                    <input class="form-control" disabled="disabled" placeholder="Snipe-IT Asset Management" name="site_name" type="text" value="{{ old('site_name', $setting->site_name) }}" id="site_name">
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    <input class="form-control" placeholder="Snipe-IT Asset Management" required="required" name="site_name" type="text" value="{{ old('site_name', $setting->site_name) }}" id="site_name">
                                @endif
                                {!! $errors->first('site_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        @php
                            $optionTypes = trans('admin/settings/general.logo_option_types');
                        @endphp

                        <!-- Branding -->
                        <div class="form-group {{ $errors->has('brand') ? 'error' : '' }}">
                            <div class="col-md-3">
                                <label for="brand">{{ trans('admin/settings/general.web_brand') }}</label>
                            </div>
                            <div class="col-md-9">
                                {!! Form::select('brand', [
                                                '1'=> trans('admin/settings/general.logo_option_types.text'),
                                                '2'=> trans('admin/settings/general.logo_option_types.logo'),
                                                '3'=> trans('admin/settings/general.logo_option_types.logo_and_text')], old('brand', $setting->brand), array('class' => 'form-control select2', 'style'=>'width: 150px ;')) !!}

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

                    <!-- Default Avatar -->
                    @include('partials/forms/edit/uploadLogo', [
                        "logoVariable" => "default_avatar",
                        "logoId" => "defaultAvatar",
                        "logoLabel" => trans('admin/settings/general.default_avatar'),
                        "logoClearVariable" => "clear_default_avatar",
                        "logoPath" => "avatars/",
                        "helpBlock" => trans('admin/settings/general.default_avatar_help').' '.trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]),
                    ])

                        @if (($setting->default_avatar == '') || (($setting->default_avatar == 'default.png') && (Storage::disk('public')->missing('default.png'))))
                        <!-- Restore Default Avatar -->
                        <div class="form-group">

                            <div class="col-md-9 col-md-offset-3">
                                <label class="form-control">
                                    <input type="checkbox" name="restore_default_avatar" value="1" @checked(old('restore_default_avatar', $setting->restore_default_avatar)) />
                                    <span>{!! trans('admin/settings/general.restore_default_avatar', ['default_avatar'=> Storage::disk('public')->url('default.png')]) !!}</span>
                                </label>
                                <p class="help-block">
                                    {{ trans('admin/settings/general.restore_default_avatar_help') }}
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Load gravatar -->
                        <div class="form-group {{ $errors->has('load_remote') ? 'error' : '' }}">
                            <div class="col-md-3">
                                <strong>{{ trans('admin/settings/general.load_remote') }}</strong>
                            </div>
                            <div class="col-md-9">
                                <label class="form-control">
                                    <input type="checkbox" name="load_remote" value="1" @checked(old('load_remote', $setting->load_remote)) />
                                    {{ trans('general.yes') }}
                                    {!! $errors->first('load_remote', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                </label>

                                <p class="help-block">
                                    {{ trans('admin/settings/general.load_remote_help_text') }}
                                </p>

                            </div>
                        </div>


                        <!-- Include logo in print assets -->
                        <div class="form-group">
                            <div class="col-md-3">
                                <strong>{{ trans('admin/settings/general.logo_print_assets') }}</strong>
                            </div>
                            <div class="col-md-9">
                                <label class="form-control">
                                    <input type="checkbox" name="logo_print_assets" value="1" @checked(old('logo_print_assets', $setting->logo_print_assets)) aria-label="logo_print_assets"/>
                                {{ trans('admin/settings/general.logo_print_assets_help') }}
                                </label>

                            </div>
                        </div>


                        <!-- show urls in emails-->
                        <div class="form-group">
                            <div class="col-md-3">
                                <strong>{{ trans('admin/settings/general.show_url_in_emails') }}</strong>
                            </div>
                            <div class="col-md-9">
                                <label class="form-control">
                                    <input type="checkbox" name="show_url_in_emails" value="1" @checked(old('show_url_in_emails', $setting->show_url_in_emails)) aria-label="show_url_in_emails" />
                                    {{ trans('general.yes') }}
                                </label>
                                <p class="help-block">{{ trans('admin/settings/general.show_url_in_emails_help_text') }}</p>
                            </div>
                        </div>

                        <!-- Header color -->
                        <div class="form-group {{ $errors->has('header_color') ? 'error' : '' }}">
                            <div class="col-md-3">
                                <label for="header_color">{{ trans('admin/settings/general.header_color') }}</label>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group header-color">
                                    <input class="form-control" style="width: 100px;" placeholder="#FF0000" aria-label="header_color" name="header_color" type="text" id="header_color" value="{{ old('header_color', $setting->header_color) }}">
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
                                <label for="skin">{{ trans('general.skin') }}</label>
                            </div>
                            <div class="col-md-9">
                                {!! Form::skin('skin', old('skin', $setting->skin), 'select2') !!}
                                {!! $errors->first('skin', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Allow User Skin -->
                        <div class="form-group">
                            <div class="col-md-3">
                                <strong>{{ trans('admin/settings/general.allow_user_skin') }}</strong>
                            </div>
                            <div class="col-md-9">
                                <label class="form-control">
                                    <input type="checkbox" name="allow_user_skin" value="1" @checked(old('allow_user_skin', $setting->allow_user_skin))/>
                                    {{ trans('general.yes') }}
                                </label>
                                <p class="help-block">{{ trans('admin/settings/general.allow_user_skin_help_text') }}</p>
                            </div>
                        </div>

                        <!-- Custom css -->
                        <div class="form-group {{ $errors->has('custom_css') ? 'error' : '' }}">
                            <div class="col-md-3">
                                <label for="custom_css">{{ trans('admin/settings/general.custom_css') }}</label>
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    <x-input.textarea
                                        name="custom_css"
                                        :value="old('custom_css', $setting->custom_css)"
                                        placeholder="Add your custom CSS"
                                        aria-label="custom_css"
                                        disabled
                                    />
                                    {!! $errors->first('custom_css', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    <x-input.textarea
                                        name="custom_css"
                                        :value="old('custom_css', $setting->custom_css)"
                                        placeholder="Add your custom CSS"
                                        aria-label="custom_css"
                                    />
                                    {!! $errors->first('custom_css', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @endif
                                <p class="help-block">{!! trans('admin/settings/general.custom_css_help') !!}</p>
                            </div>
                        </div>


                        <!-- Support Footer -->
                        <div class="form-group {{ $errors->has('support_footer') ? 'error' : '' }}">
                            <div class="col-md-3">
                                <label for="support_footer">{{ trans('admin/settings/general.support_footer') }}</label>
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {!! Form::select('support_footer', array('on'=>trans('admin/settings/general.enabled'),'off'=>trans('admin/settings/general.two_factor_disabled'),'admin'=>trans('admin/settings/general.super_admin_only')), old('support_footer', $setting->support_footer), ['class' => 'form-control select2 disabled', 'style'=>'width: 150px ;', 'disabled' => 'disabled']) !!}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    {!! Form::select('support_footer', array('on'=>trans('admin/settings/general.enabled'),'off'=>trans('admin/settings/general.two_factor_disabled'),'admin'=>trans('admin/settings/general.super_admin_only')), old('support_footer', $setting->support_footer), array('class' => 'form-control select2', 'style'=>'width: 150px ;')) !!}
                                @endif


                                {!! $errors->first('support_footer', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>


                        <!-- Version Footer -->
                        <div class="form-group {{ $errors->has('version_footer') ? 'error' : '' }}">
                            <div class="col-md-3">
                                <label for="version_footer">{{ trans('admin/settings/general.version_footer') }}</label>
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    {!! Form::select('version_footer', array('on'=>trans('admin/settings/general.enabled'),'off'=>trans('admin/settings/general.two_factor_disabled'),'admin'=>trans('admin/settings/general.super_admin_only')), old('version_footer', $setting->version_footer), ['class' => 'form-control select2 disabled', 'style'=>'width: 150px ;', 'disabled' => 'disabled']) !!}
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    {!! Form::select('version_footer', array('on'=>trans('admin/settings/general.enabled'),'off'=>trans('admin/settings/general.two_factor_disabled'),'admin'=>trans('admin/settings/general.super_admin_only')), old('version_footer', $setting->version_footer), array('class' => 'form-control select2', 'style'=>'width: 150px ;')) !!}
                                @endif

                                <p class="help-block">{{ trans('admin/settings/general.version_footer_help') }}</p>
                                {!! $errors->first('version_footer', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Additional footer -->
                        <div class="form-group {{ $errors->has('footer_text') ? 'error' : '' }}">
                            <div class="col-md-3">
                                <label for="footer_text">{{ trans('admin/settings/general.footer_text') }}</label>
                            </div>
                            <div class="col-md-9">
                                @if (config('app.lock_passwords')===true)
                                    <x-input.textarea
                                        name="footer_text"
                                        :value="old('footer_text', $setting->footer_text)"
                                        rows="4"
                                        placeholder="Optional footer text"
                                        disabled
                                    />
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @else
                                    <x-input.textarea
                                        name="footer_text"
                                        :value="old('footer_text', $setting->footer_text)"
                                        rows="4"
                                        placeholder="Optional footer text"
                                    />
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
                        <button type="submit" class="btn btn-primary"><x-icon type="checkmark" /> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    </form>

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
