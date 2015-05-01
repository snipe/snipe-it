@extends('backend/layouts/default')

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
                    <i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
                </div>

                <h3 class="name">@lang('admin/settings/general.update')</h3>


                <div class="profile">
	                
                    <!-- bio, new note & orders column -->
                    
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>

								{{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal', 'role' => 'form' ]) }}
                                <!-- CSRF Token -->
                                {{ Form::hidden('_token', csrf_token()) }}

									
                                @foreach ($settings as $setting)
									
									<h4>@lang('admin/settings/general.general_settings')</h4>
									
                                    <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">
	                                    <div class="col-md-3">
                                        {{ Form::label('site_name', Lang::get('admin/settings/general.site_name')) }}
	                                    </div>
	                                    <div class="col-md-9">
		                                   @if (Config::get('app.lock_passwords')===true)
		                                   		{{ Form::text('site_name', Input::old('site_name', $setting->site_name), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'Snipe-IT Asset Management')) }}
		                                   @else 
		                                   		{{ Form::text('site_name', Input::old('site_name', $setting->site_name), array('class' => 'form-control','placeholder' => 'Snipe-IT Asset Management')) }}

		                                   @endif
		                                   
										  {{ $errors->first('site_name', '<br><span class="alert-msg">:message</span>') }}
	                                    </div>
                                    </div>

                                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">

	                                    <div class="col-md-3">
										 	{{ Form::label('logo', Lang::get('admin/settings/general.logo')) }}
	                                    </div>
	                                    <div class="col-md-9">
						                    {{ Form::file('logo') }}
						                    {{ $errors->first('logo', '<br><span class="alert-msg">:message</span>') }}
						                    {{ Form::checkbox('clear_logo', '1', Input::old('clear_logo')) }} Remove
	                                    </div>

						            </div>


						            <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
	                                    <div class="col-md-3">
                                        {{ Form::label('alert_email', Lang::get('admin/settings/general.alert_email')) }}
	                                    </div>
	                                    <div class="col-md-9">
										{{ Form::text('alert_email', Input::old('alert_email', $setting->alert_email), array('class' => 'form-control','placeholder' => 'admin@yourcompany.com')) }}


										{{ Form::checkbox('alerts_enabled', '1', Input::old('alerts_enabled', $setting->alerts_enabled)) }}
										@Lang('admin/settings/general.alerts_enabled')


										{{ $errors->first('alert_email', '<br><span class="alert-msg">:message</span>') }}
	                                    </div>
                                    </div>


									<div class="form-group {{ $errors->has('header_color') ? 'error' : '' }}">
										<div class="col-md-3">
                                        {{ Form::label('header_color', Lang::get('admin/settings/general.header_color')) }}
                                        </div>
	                                    <div class="col-md-9">

										{{ Form::text('header_color', Input::old('header_color', $setting->header_color), array('class' => 'form-control', 'style' => 'width: 100px;')) }}
										{{ $errors->first('header_color', '<br><span class="alert-msg">:message</span>') }}
	                                    </div>
                                    </div>

									 <div class="form-group {{ $errors->has('per_page') ? 'error' : '' }}">
                                        <div class="col-md-3">
											{{ Form::label('per_page', Lang::get('admin/settings/general.per_page')) }}
										</div>
	                                    <div class="col-md-9">
										{{ Form::select('per_page', array('10'=>'10','25'=>'25','50'=>'50','75'=>'75','100'=>'100','125'=>'125','150'=>'150'), Input::old('per_page', $setting->per_page), array('class' => 'form-control', 'style'=>'width: 100px;')) }}
										{{ $errors->first('per_page', '<br><span class="alert-msg">:message</span>') }}
										</div>
                                    </div>

                      

                                   <div class="checkbox col-md-offset-3">
										<label>
											{{ Form::checkbox('load_remote', '1', Input::old('load_remote', $setting->load_remote)) }}
											@lang('admin/settings/general.load_remote')
										</label>
                                    </div>
                                    <hr>
									<h4>@lang('admin/settings/general.asset_ids') (@lang('admin/settings/general.optional'))</h4>
                                    <div class="checkbox col-md-offset-3">
										<label>
											{{ Form::checkbox('auto_increment_assets', '1', Input::old('auto_increment_assets', $setting->auto_increment_assets)) }}
											@lang('admin/settings/general.auto_increment_assets')
										</label>
                                    </div>

                                    <div class="form-group {{ $errors->has('auto_increment_prefix') ? 'error' : '' }}">
                                            <div class="col-md-3">
	                                            {{ Form::label('auto_increment_prefix', Lang::get('admin/settings/general.auto_increment_prefix')) }}
											</div>
	                                    <div class="col-md-9">
                                         @if ($setting->auto_increment_assets == 1)
											{{ Form::text('auto_increment_prefix', Input::old('auto_increment_prefix', $setting->auto_increment_prefix), array('class' => 'form-control', 'style'=>'width: 100px;')) }}
											{{ $errors->first('auto_increment_prefix', '<br><span class="alert-msg">:message</span>') }}
										@else
											{{ Form::text('auto_increment_prefix', Input::old('auto_increment_prefix', $setting->auto_increment_prefix), array('class' => 'form-control', 'disabled'=>'disabled', 'style'=>'width: 100px;')) }}
										@endif

										</div>
                                    </div>



									<hr>
									<h4>@lang('admin/settings/general.barcode_settings') (@lang('admin/settings/general.optional'))</h4>
                                    @if ($is_gd_installed)

                                    		<div class="checkbox col-md-offset-3 col-md-9" style="padding-bottom: 10px;">
												<label>
													{{ Form::checkbox('qr_code', '1', Input::old('qr_code', $setting->qr_code)) }}
													@lang('admin/settings/general.display_qr')
												</label>
											</div>

										<!-- Code type -->
										<div class="form-group{{ $errors->has('barcode_type') ? ' has-error' : '' }}">
											<div class="col-md-3">
											 {{ Form::label('barcode_type', Lang::get('admin/settings/general.barcode_type')) }}
											 </div>

												<div class="col-md-9">
												 {{ Form::barcode_types('barcode_type', Input::old('barcode_type', $setting->barcode_type), 'select2') }}

												{{ $errors->first('barcode_type', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
												</div>
										</div>



									<div class="form-group {{ $errors->has('qr_text') ? 'error' : '' }}">
										<div class="col-md-3">
                                        {{ Form::label('qr_text', Lang::get('admin/settings/general.qr_text')) }}
										</div>
	                                    <div class="col-md-9">
                                         @if ($setting->qr_code == 1)
											{{ Form::text('qr_text', Input::old('qr_text', $setting->qr_text), array('class' => 'form-control','placeholder' => 'Property of Your Company')) }}
											{{ $errors->first('qr_text', '<br><span class="alert-msg">:message</span>') }}
										@else
											{{ Form::text('qr_text', Input::old('qr_text', $setting->qr_text), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'Property of Your Company')) }}
											<p class="help-inline">
                                                @lang('admin/settings/general.qr_help')
                                            </p>
										@endif
	                                    </div>

                                    </div>

                                    @else
                                            <span class="help-inline col-md-offset-3 col-md-12">
                                                @lang('admin/settings/general.php_gd_warning')
                                                <br>
                                                @lang('admin/settings/general.php_gd_info')
                                            </span>
                                    @endif



									<hr>
									<h4>@lang('admin/settings/general.eula_settings') (@lang('admin/settings/general.optional'))</h4>
									<div class="form-group {{ $errors->has('default_eula_text') ? 'error' : '' }}">
	                                    <div class="col-md-3">
                                        {{ Form::label('default_eula_text', Lang::get('admin/settings/general.default_eula_text')) }}
	                                    </div>
	                                    <div class="col-md-9">
										{{ Form::textarea('default_eula_text', Input::old('default_eula_text', $setting->default_eula_text), array('class' => 'form-control','placeholder' => 'Add your default EULA text')) }}
										{{ $errors->first('default_eula_text', '<br><span class="alert-msg">:message</span>') }}

										 <p class="help-inline">@lang('admin/settings/general.default_eula_help_text')</p>
										 <p class="help-inline">@lang('admin/settings/general.eula_markdown')</p>

	                                    </div>


                                    </div>
                                    
                                    <hr>
                                    <h4>@lang('admin/settings/general.slack_integration') (@lang('admin/settings/general.optional'))</h4>
                                    <p class="help-inline">@lang('admin/settings/general.slack_integration_help',array('slack_link' => 'https://my.slack.com/services/new/incoming-webhook'))</p>
                                    <div class="form-group {{ $errors->has('slack_channel') ? 'error' : '' }}">
	                                    <div class="col-md-3">
                                        {{ Form::label('slack_endpoint', Lang::get('admin/settings/general.slack_endpoint')) }}
	                                    </div>
	                                    <div class="col-md-9">
		                                    
		                                    @if (Config::get('app.lock_passwords')===true)
		                                     	{{ Form::text('slack_endpoint', Input::old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX')) }}
		                                   @else 
		                                   		{{ Form::text('slack_endpoint', Input::old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX')) }}
		                                   @endif
		                                   
										{{ $errors->first('slack_endpoint', '<br><span class="alert-msg">:message</span>') }}
	                                    </div>
                                    </div>
                                    
                                    <div class="form-group {{ $errors->has('slack_channel') ? 'error' : '' }}">
	                                    <div class="col-md-3">
                                        {{ Form::label('slack_channel', Lang::get('admin/settings/general.slack_channel')) }}
	                                    </div>
	                                    <div class="col-md-9">
										@if (Config::get('app.lock_passwords')===true)
		                                     	{{ Form::text('slack_channel', Input::old('slack_channel', $setting->slack_channel), array('class' => 'form-control','disabled'=>'disabled','placeholder' => '#IT-Ops')) }}
		                                @else 
		                                   		{{ Form::text('slack_channel', Input::old('slack_channel', $setting->slack_channel), array('class' => 'form-control','placeholder' => '#IT-Ops')) }}
		                                @endif										
		                                {{ $errors->first('slack_channel', '<br><span class="alert-msg">:message</span>') }}
	                                    </div>
                                    </div>
                                    
                                    <div class="form-group {{ $errors->has('slack_botname') ? 'error' : '' }}">
	                                    <div class="col-md-3">
                                        {{ Form::label('slack_botname', Lang::get('admin/settings/general.slack_botname')) }}
	                                    </div>
	                                    <div class="col-md-9">
										@if (Config::get('app.lock_passwords')===true)
		                                     	{{ Form::text('slack_botname', Input::old('slack_botname', $setting->slack_botname), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'Snipe-IT Bot')) }}
		                                @else 
		                                   		{{ Form::text('slack_botname', Input::old('slack_botname', $setting->slack_botname), array('class' => 'form-control','placeholder' => 'Snipe-IT Bot')) }}
		                                @endif		
		                                {{ $errors->first('slack_botname', '<br><span class="alert-msg">:message</span>') }}
	                                    </div>
                                    </div>




                                @endforeach

                                <!-- Form actions -->
                                    <div class="form-group">
                                        <div class="controls col-md-offset-3">
                                            <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                                            <button type="submit" class="btn-flat success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
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

</div>
@stop
