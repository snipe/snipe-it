@extends('backend/layouts/default')

<?php
use DebugBar\StandardDebugBar;

$debugbar = new StandardDebugBar();
$debugbarRenderer = $debugbar->getJavascriptRenderer();

$debugbar["messages"]->addMessage("hello world!");
?>

{{-- Page title --}}
@section('title')
        @lang('admin/settings/general.update') ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->

                <div class="pull-right">
                    <a href="{{ URL::previous() }}" class="btn-flat gray">
                    <i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
                </div>

                <h3 class="name">@lang('admin/settings/general.update')</h3>


                <div class="row-fluid profile">
                    <!-- edit system settings column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- list settings form -->

                            <form class="form-horizontal" method="post" action="" autocomplete="off">
                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-3">@lang('admin/settings/general.setting')</th>
                                    <th class="col-md-3"><span class="line"></span>@lang('admin/settings/general.value')</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($settings as $setting)

                                <tr {{ $errors->has('site_name') ? 'error' : '' }}">
                                    <td for="site_name">@lang('admin/settings/general.sitename')</td>
                                        <td>
                                            <input maxlength="64" size="40" type="text" name="site_name" id="site_name" value="{{{ Input::old('site_name', $setting->site_name) }}}" />
                                            {{ $errors->first('site_name', '<span class="help-inline">:message</span>') }}
                                        </td>
                                </tr>
                                <tr {{ $errors->has('display_asset_name') ? 'error' : '' }}">
                                        <td for="display_asset_name">@lang('admin/settings/general.display_asset_name')</td>
                                    <td>
                                            <input type="checkbox" name="display_asset_name" id="display_asset_name" value="1" {{{ $setting->display_asset_name === 1 ? 'checked' : '' }}} />
                                            {{ $errors->first('display_asset_name', '<span class="help-inline">:message</span>') }}
                                    </td>
                                </tr>
                                    <tr {{ $errors->has('per_page') ? 'error' : '' }}">
                                        <td for="per_page">@lang('admin/settings/general.rowsperpage')</td>
                                        <td>
                                            <input  maxlength="3" size="3" type="text" name="per_page" id="per_page" value="{{{ Input::old('per_page', $setting->per_page) }}}" />
                                            {{ $errors->first('per_page', '<span class="help-inline">:message</span>') }}
                                        </td>
                                    </tr>

                                    <tr {{ $errors->has('qr_code') ? 'error' : '' }}">
                                        <td for="qr_code">@lang('admin/settings/general.displayqrcodes')</td>
                                        <td>
                                    @if ($is_gd_installed)
                                            <input type="checkbox" name="qr_code" id="qr_code" value="1" {{ $setting->qr_code === 1 ? 'checked' : '' }} />
                                    @else
                                            <span class="help-inline">
                                                @lang('admin/settings/general.php_gd_warning')
                                                <br>
                                                @lang('admin/settings/general.php_gd_info')
                                            </span>
                                    @endif
                                            {{ $errors->first('qr_code', '<span class="help-inline">:message</span>') }}
                                            </td>
                                    </tr>

                                    <tr {{ $errors->has('qr_text') ? 'error' : '' }}">
                                        <td for="qr_text"> @lang('admin/settings/general.qr_text')</td>
                                        <td>
                                    @if ($setting->qr_code === 1)
                                            <input  maxlength="16" size="16" type="text" name="qr_text" id="qr_text" value="{{{ Input::old('qr_text', $setting->qr_text) }}}" />
                                    @else
                                            <span class="help-inline">
                                                @lang('admin/settings/general.qr_help')

                                            </span>
                                    @endif
                                            {{ $errors->first('qr_text', '<span class="help-inline">:message</span>') }}
                                            </td>
                                    </tr>

                                    <tr {{ $errors->has('showsysinfo') ? 'error' : '' }}">
                                        <td for="showsysinfo">
                                        @lang('admin/settings/general.showsysinfo')
                                        </td>
                                        <td>

                                            <input type="checkbox" name="showsysinfo" id="showsysinfo" value="1" {{{ $setting->showsysinfo === 1 ? 'checked' : '' }}} />

                                            {{ $errors->first('showsysinfo', '<span class="help-inline">:message</span>') }}
                                            </td>
                                    </tr>
                            </tbody>
                            </table>
                                @endforeach

                                <!-- Form actions -->
                            
                            <div>
                                            <br>
                                            <a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
                                            <button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
                            </div>
                            
                            </form>

                        </div>
</div>

                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
                    <br /><br />
                        <p>@lang('admin/settings/general.settings_info')</p>

                    </div>


@stop
