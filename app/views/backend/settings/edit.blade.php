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
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <form class="form-horizontal" method="post" action="" autocomplete="off">
                                <!-- CSRF Token -->
                                {{ Form::hidden('_token', csrf_token()) }}
                                
                                @foreach ($settings as $setting)

                                    <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">
                                        {{ Form::label('site_name', Lang::get('admin/settings/general.site_name'), array('class' => 'control-label')) }}
                                        <div class="controls">
                                            {{ Form::text('site_name', Input::old('site_name', $setting->site_name), array('class' => 'col-md-9')) }}
                                            {{ $errors->first('site_name', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('display_asset_name') ? 'error' : '' }}">
                                        {{ Form::label('display_asset_name', Lang::get('admin/settings/general.display_asset_name'), array('class' => 'control-label')) }}
                                        <div class="controls">
                                            {{ Form::checkbox('display_asset_name', '1', Input::old('display_asset_name', $setting->display_asset_name)) }}
                                            {{ $errors->first('display_asset_name', '<span class="help-inline">:message</span>') }}
                                            </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('display_checkout_date') ? 'error' : '' }}">
                                        {{ Form::label('display_checkout_date', Lang::get('admin/settings/general.display_checkout_date'), array('class' => 'control-label')) }}
                                        <div class="controls">
                                            {{ Form::checkbox('display_checkout_date', '1', Input::old('display_checkout_date', $setting->display_checkout_date)) }}
                                            {{ $errors->first('display_checkout_date', '<span class="help-inline">:message</span>') }}
                                            </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('per_page') ? 'error' : '' }}">
                                        {{ Form::label('per_page', Lang::get('admin/settings/general.per_page'), array('class' => 'control-label')) }}
                                        <div class="controls">
                                            {{ Form::text('per_page', Input::old('per_page', $setting->per_page))}}
                                            {{ $errors->first('per_page', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('qr_code') ? 'error' : '' }}">
                                        {{ Form::label('qr_code', Lang::get('admin/settings/general.display_qr'), array('class' => 'control-label')) }}
                                        <div class="controls">
                                    @if ($is_gd_installed)
                                            {{ Form::checkbox('qr_code', '1', Input::old('qr_code', $setting->qr_code)) }}

                                    @else
                                            <span class="help-inline">
                                                @lang('admin/settings/general.php_gd_warning')
                                                <br>
                                                @lang('admin/settings/general.php_gd_info')
                                            </span>
                                    @endif
                                            {{ $errors->first('qr_code', '<span class="help-inline">:message</span>') }}
                                            </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('qr_text') ? 'error' : '' }}">
                                        {{ Form::label('qr_text', Lang::get('admin/settings/general.qr_text'), array('class' => 'control-label')) }}
                                        <div class="controls">
                                    @if ($setting->qr_code == 1)
                                            {{ Form::text('qr_text', Input::old('qr_text', $setting->qr_text), array('class' => 'col-md-9')) }}
                                    @else
                                            <span class="help-inline">
                                                @lang('admin/settings/general.qr_help')

                                            </span>
                                    @endif
                                            {{ $errors->first('qr_text', '<span class="help-inline">:message</span>') }}
                                            </div>
                                    </div>



                                @endforeach

                                <!-- Form actions -->
                                    <div class="form-group">
                                        <div class="controls">
                                            <a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
                                            <button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
                                        </div>
                                </div>
                            </form>

                        </div>
</div>

                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
                    <br /><br />
                        <p>@lang('admin/settings/general.info')</p>

                    </div>

@stop
