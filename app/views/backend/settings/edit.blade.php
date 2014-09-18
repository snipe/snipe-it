@extends('backend/layouts/default')


{{-- Page title --}}
@section('title')
@lang('base.setting_update') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off">

    <!-- header -->
    <div class="row header">
        <div class="col-md-10">

            <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
            <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>

            <h3 class="name">@lang('base.setting_update')</h3>

        </div>                            
    </div>
    <!-- list settings form -->
    <div class="col-md-1"><br></div>
    <div class="col-md-7">


        <!-- CSRF Token -->

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <table class="table table-hover">
            <thead>
                <!--<tr>
                    <th class="col-md-3">@lang('base.setting_shortname')</th>
                    <th class="col-md-7"><span class="line"></span>@lang('general.value')</th>
                </tr> -->
            </thead>
            <tbody>

                @foreach ($settings as $setting)

                <tr {{ $errors->has('site_name') ? 'error' : '' }}">
                    <td for="site_name">@lang('admin/settings/form.sitename')</td>
                    <td>
                        <div class="col-md-12"><input class="form-control" maxlength="64" size="40" type="text" name="site_name" 
                        id="site_name" value="{{{ Input::old('site_name', $setting->site_name) }}}" /></div>
                        {{ $errors->first('site_name', '<span class="help-inline">:message</span>') }}
                    </td>
                </tr>
                <tr {{ $errors->has('display_asset_name') ? 'error' : '' }}">
                    <td for="display_asset_name">@lang('admin/settings/form.display_asset_name')</td>
                    <td>
                        <div class="col-md-5"><input type="checkbox" name="display_asset_name" id="display_asset_name" 
                                                     value="1" {{{ $setting->display_asset_name === 1 ? 'checked' : '' }}} /></div>
                        {{ $errors->first('display_asset_name', '<span class="help-inline">:message</span>') }}
                    </td>
                </tr>
                <tr {{ $errors->has('per_page') ? 'error' : '' }}">
                    <td for="per_page">@lang('admin/settings/form.rowsperpage')</td>
                    <td>
                        <div class="col-md-3"><input class="form-control" maxlength="3" size="3" type="text" name="per_page" 
                                                     id="per_page" value="{{{ Input::old('per_page', $setting->per_page) }}}" /></div>
                        {{ $errors->first('per_page', '<span class="help-inline">:message</span>') }}
                    </td>
                </tr>
                <tr {{ $errors->has('multiplelogons') ? 'error' : '' }}">
                    <td for="multiplelogons">
                        @lang('admin/settings/form.multiplelogons')
                    </td>
                    <td>
                        <div class="col-md-5"><input type="checkbox" name="multiplelogons" id="multiplelogons" 
                                                     value="1" {{{ $setting->multiplelogons === 1 ? 'checked' : '' }}} /></div>
                        {{ $errors->first('multiplelogons', '<span class="help-inline">:message</span>') }}
                    </td>
                </tr>
                <tr {{ $errors->has('qr_code') ? 'error' : '' }}">
                    <td for="qr_code">@lang('admin/settings/form.displayqrcodes')</td>
                    <td>
                        @if ($is_gd_installed)
                        <div class="col-md-5"><input type="checkbox" name="qr_code" id="qr_code" value="1" {{ $setting->qr_code === 1 ? 'checked' : '' }} /></div>
                        @else
                        <span class="help-inline">
                            @lang('admin/settings/message.php_gd_warning')
                            <br>
                            @lang('admin/settings/message.php_gd_info')
                        </span>
                        <span class="help-inline">
                            @lang('admin/settings/form.qr_help')

                        </span>
                        @endif
                        {{ $errors->first('qr_code', '<span class="help-inline">:message</span>') }}
                    </td>
                </tr>

                <tr {{ $errors->has('qr_text') ? 'error' : '' }}">
                    <td for="qr_text"> @lang('admin/settings/form.qr_text')</td>
                    <td>
                        <div class="col-md-7">
                        @if ($setting->qr_code === 1)
                        <input class="form-control" maxlength="16" size="10" type="text" name="qr_text" 
                                                     id="qr_text" value="{{{ Input::old('qr_text', $setting->qr_text) }}}" />
                        @else
                        <span class="help-inline">
                            @lang('admin/settings/form.qr_help')
                        </span>
                        @endif
                        </div>
                        {{ $errors->first('qr_text', '<span class="help-inline">:message</span>') }}
                    </td>
                </tr>

                <tr {{ $errors->has('showsysinfo') ? 'error' : '' }}">
                    <td for="showsysinfo">
                        @lang('admin/settings/form.showsysinfo')
                    </td>
                    <td>
                        <div class="col-md-5"><input type="checkbox" name="showsysinfo" id="showsysinfo" 
                                                     value="1" {{{ $setting->showsysinfo === 1 ? 'checked' : '' }}} /></div>
                        {{ $errors->first('showsysinfo', '<span class="help-inline">:message</span>') }}
                    </td>
                </tr>

            </tbody>
        </table>
        @endforeach

        <!-- Form actions -->
        <div class="form-group">
            <br>
            <label class="col-md-0 control-label"></label>
            <div class="col-md-7">
                <a href="{{ URL::previous() }}" class="btn btn-default"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
                <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>
            </div>
        </div>



    </div>

</form>
@stop
