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

<style>
.checkbox {
padding-left: 0px;
}
#pad-wrapper {
padding: 0px 20px;
}
</style>

<div id="pad-wrapper" class="user-profile">
                <!-- header -->

                <div class="pull-right">
                    <a href="{{ URL::previous() }}" class="btn-flat gray">
                    <i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
                </div>

                <h3 class="name">@lang('admin/settings/general.update')</h3>


                <div class="profile">
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>


                            <form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
                                <!-- CSRF Token -->
                                {{ Form::hidden('_token', csrf_token()) }}


                                @foreach ($settings as $setting)

                                    <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">
                                        {{ Form::label('site_name', Lang::get('admin/settings/general.site_name')) }}
										{{ Form::text('site_name', Input::old('site_name', $setting->site_name), array('class' => 'form-control')) }}
										{{ $errors->first('site_name', '<span class="help-inline">:message</span>') }}
                                    </div>

									 <div class="form-group {{ $errors->has('per_page') ? 'error' : '' }}">
                                        {{ Form::label('per_page', Lang::get('admin/settings/general.per_page')) }}
										{{ Form::text('per_page', Input::old('per_page', $setting->per_page), array('class' => 'form-control', 'style'=>'width: 100px;')) }}
										{{ $errors->first('per_page', '<span class="help-inline">:message</span>') }}

                                    </div>


                                    <div class="checkbox">
										<label>
											{{ Form::checkbox('display_asset_name', '1', Input::old('display_asset_name', $setting->display_asset_name)) }}
											@lang('admin/settings/general.display_asset_name')
										</label>
                                    </div>

                                     <div class="checkbox">
										<label>
											{{ Form::checkbox('display_eol', '1', Input::old('display_eol', $setting->display_eol)) }}
											@lang('admin/settings/general.display_eol')
										</label>
                                    </div>

                                     <div class="checkbox">
										<label>
											{{ Form::checkbox('display_checkout_date', '1', Input::old('display_checkout_date', $setting->display_checkout_date)) }}
											@lang('admin/settings/general.display_checkout_date')
										</label>
                                    </div>
                                    <hr>

                                    <div class="checkbox">
										<label>
											{{ Form::checkbox('auto_increment_assets', '1', Input::old('auto_increment_assets', $setting->auto_increment_assets)) }}
											@lang('admin/settings/general.auto_increment_assets')
										</label>
                                    </div>

                                    <div class="form-group {{ $errors->has('auto_increment_prefix') ? 'error' : '' }}">
                                            {{ Form::label('auto_increment_prefix', Lang::get('admin/settings/general.auto_increment_prefix')) }}

                                         @if ($setting->auto_increment_assets == 1)
											{{ Form::text('auto_increment_prefix', Input::old('auto_increment_prefix', $setting->auto_increment_prefix), array('class' => 'form-control', 'style'=>'width: 100px;')) }}
											{{ $errors->first('auto_increment_prefix', '<span class="help-inline">:message</span>') }}
										@else
											{{ Form::text('auto_increment_prefix', Input::old('auto_increment_prefix', $setting->auto_increment_prefix), array('class' => 'form-control', 'disabled'=>'disabled', 'style'=>'width: 100px;')) }}
											<p class="help-inline">
                                                @lang('admin/settings/general.qr_help')
                                            </p>
										@endif


                                    </div>



									<hr>

                                    @if ($is_gd_installed)

                                    		<div class="checkbox">
												<label>
													{{ Form::checkbox('qr_code', '1', Input::old('qr_code', $setting->qr_code)) }}
													@lang('admin/settings/general.display_qr')
												</label>
											</div>

                                    @else
                                            <span class="help-inline">
                                                @lang('admin/settings/general.php_gd_warning')
                                                <br>
                                                @lang('admin/settings/general.php_gd_info')
                                            </span>
                                    @endif


									<div class="form-group {{ $errors->has('qr_text') ? 'error' : '' }}">
                                        {{ Form::label('qr_text', Lang::get('admin/settings/general.qr_text')) }}

                                         @if ($setting->qr_code == 1)
											{{ Form::text('qr_text', Input::old('qr_text', $setting->qr_text), array('class' => 'form-control')) }}
											{{ $errors->first('qr_text', '<span class="help-inline">:message</span>') }}
										@else
											{{ Form::text('qr_text', Input::old('qr_text', $setting->qr_text), array('class' => 'form-control', 'disabled'=>'disabled')) }}
											<p class="help-inline">
                                                @lang('admin/settings/general.qr_help')
                                            </p>
										@endif

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
