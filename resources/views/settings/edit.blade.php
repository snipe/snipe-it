@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/settings/general.update') }}
@parent
@stop


{{-- Page content --}}
@section('content')


<style>
.checkbox label {
  padding-right: 40px;
}

.input-group-addon {
  width: 30px;
}

</style>

<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('assets/js/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">


{{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal', 'role' => 'form' ]) }}
<!-- CSRF Token -->
{{ Form::hidden('_token', csrf_token()) }}



<div class="row">
  <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

    <div class="panel box box-default">
      <div class="box-header">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
        </div><!-- /box tools -->
      </div> <!-- /box header -->
      <div class="box-body">
        <div class="box-group" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel box box-primary">
              <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="accordion-header">
                    <i class="fa fa-cogs"></i> {{ trans('admin/settings/general.general_settings') }}
                  </a>
                </h4>
              </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabbox" aria-labelledby="headingOne">
              <div class="box-body">

                <!-- Site name -->
                <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('site_name', trans('admin/settings/general.site_name')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('site_name', Input::old('site_name', $setting->site_name), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'Snipe-IT Asset Management')) }}
                    @else
                      {{ Form::text('site_name',
                          Input::old('site_name', $setting->site_name), array('class' => 'form-control','placeholder' => 'Snipe-IT Asset Management')) }}
                    @endif
                    {!! $errors->first('site_name', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Two Factor -->
                <div class="form-group {{ $errors->has('brand') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('two_factor_enabled', trans('admin/settings/general.two_factor_enabled_text')) }}
                  </div>
                  <div class="col-md-9">

                    {!! Form::two_factor_options('two_factor_enabled', Input::old('two_factor_enabled', $setting->two_factor_enabled), 'select2') !!}
                    <p class="help-block">{{ trans('admin/settings/general.two_factor_enabled_warning') }}</p>

                    @if (config('app.lock_passwords'))
                    <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                    @endif

                    {!! $errors->first('two_factor_enabled', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Languages -->
                <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('site_name', trans('admin/settings/general.default_language')) }}
                  </div>
                  <div class="col-md-9">
                     {!! Form::locales('locale', Input::old('locale', $setting->locale), 'select2') !!}

                    {!! $errors->first('locale', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Full Multiple Companies Support -->
                <div class="form-group {{ $errors->has('full_multiple_companies_support') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('full_multiple_companies_support',
                                   trans('admin/settings/general.full_multiple_companies_support_text')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::checkbox('full_multiple_companies_support', '1', Input::old('full_multiple_companies_support', $setting->full_multiple_companies_support),array('class' => 'minimal')) }}
                    {{ trans('admin/settings/general.full_multiple_companies_support_text') }}
                    {!! $errors->first('full_multiple_companies_support', '<span class="alert-msg">:message</span>') !!}
                    <p class="help-block">{{ trans('admin/settings/general.full_multiple_companies_support_help_text') }}</p>
                  </div>
                </div>
                <!-- /.form-group -->

                <!-- Require signature for acceptance -->
                <div class="form-group {{ $errors->has('require_accept_signature') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('full_multiple_companies_support',
                                   trans('admin/settings/general.require_accept_signature')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::checkbox('require_accept_signature', '1', Input::old('require_accept_signature', $setting->require_accept_signature),array('class' => 'minimal')) }}
                    {{ trans('general.yes') }}
                    {!! $errors->first('require_accept_signature', '<span class="alert-msg">:message</span>') !!}
                    <p class="help-block">{{ trans('admin/settings/general.require_accept_signature_help_text') }}</p>
                  </div>
                </div>
                <!-- /.form-group -->

                <!-- Logo -->
                <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('logo', trans('admin/settings/general.logo')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords'))
                        <p class="help-block">{{ trans('general.lock_passwords') }}</p>
                    @else
                      {{ Form::file('logo_img') }}
                      {!! $errors->first('logo', '<span class="alert-msg">:message</span>') !!}
                      {{ Form::checkbox('clear_logo', '1', Input::old('clear_logo'),array('class' => 'minimal')) }} Remove
                    @endif
                  </div>
                </div>

                <!-- Branding -->
                <div class="form-group {{ $errors->has('brand') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('brand', trans('admin/settings/general.brand')) }}
                  </div>
                  <div class="col-md-9">
                    {!! Form::select('brand', array('1'=>'Text','2'=>'Logo','3'=>'Logo + Text'), Input::old('brand', $setting->brand), array('class' => 'form-control', 'style'=>'width: 150px ;')) !!}
                    {!! $errors->first('brand', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Currency -->
                <div class="form-group {{ $errors->has('default_currency') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('default_currency', trans('admin/settings/general.default_currency')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::text('default_currency', Input::old('default_currency', $setting->default_currency), array('class' => 'form-control','placeholder' => 'USD', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                    {!! $errors->first('default_currency', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Email domain -->
                <div class="form-group {{ $errors->has('email_domain') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('email_domain', trans('general.email_domain')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::text('email_domain', Input::old('email_domain', $setting->email_domain), array('class' => 'form-control','placeholder' => 'example.com')) }}
                    <span class="help-block">{{ trans('general.email_domain_help')  }}</span>

                    {!! $errors->first('email_domain', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>


                <!-- Email format -->
                <div class="form-group {{ $errors->has('email_format') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('email_format', trans('general.email_format')) }}
                  </div>
                  <div class="col-md-9">
                    {!! Form::username_format('email_format', Input::old('email_format', $setting->email_format), 'select2') !!}

                    {!! $errors->first('email_format', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Username format -->
                <div class="form-group {{ $errors->has('username_format') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('username_format', trans('general.username_format')) }}
                  </div>
                  <div class="col-md-9">
                    {!! Form::username_format('username_format', Input::old('username_format', $setting->username_format), 'select2') !!}

                    {!! $errors->first('username_format', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Alert Email -->
                <div class="form-group {{ $errors->has('alert_email') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('alert_email', trans('admin/settings/general.alert_email')) }}
                  </div>
                  <div class="col-md-5">
                    {{ Form::text('alert_email', Input::old('alert_email', $setting->alert_email), array('class' => 'form-control','placeholder' => 'admin@yourcompany.com',
                    'rel' => 'txtTooltip',
                    'title' =>'Email addresses or distribution lists you want alerts to be sent to, comma separated.',
                    'data-toggle' =>'tooltip',
                    'data-placement'=>'top')) }}
                    {!! $errors->first('alert_email', '<span class="alert-msg">:message</span><br>') !!}

                    {{ Form::checkbox('alerts_enabled', '1', Input::old('alerts_enabled', $setting->alerts_enabled),array('class' => 'minimal')) }}
                    {{ trans('admin/settings/general.alerts_enabled') }}

                  </div>
                </div>

                <!-- Alert interval -->
                <div class="form-group {{ $errors->has('alert_interval') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('alert_interval', trans('admin/settings/general.alert_interval')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::text('alert_interval', Input::old('alert_interval', $setting->alert_interval), array('class' => 'form-control','placeholder' => '30', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                    {!! $errors->first('alert_interval', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Alert threshold -->
                <div class="form-group {{ $errors->has('alert_threshold') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('alert_threshold', trans('admin/settings/general.alert_inv_threshold')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::text('alert_threshold', Input::old('alert_threshold', $setting->alert_threshold), array('class' => 'form-control','placeholder' => '5', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                    {!! $errors->first('alert_threshold', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>




                <!-- Header color -->
                <div class="form-group {{ $errors->has('header_color') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('header_color', trans('admin/settings/general.header_color')) }}
                  </div>
                  <div class="col-md-2">
                      <div class="input-group header-color">
                        {{ Form::text('header_color', Input::old('header_color', $setting->header_color), array('class' => 'form-control', 'style' => 'width: 100px;','placeholder' => '#FF0000')) }}
                        <div class="input-group-addon">
                          <i></i>
                        </div>
                      </div><!-- /.input group -->


                    {!! $errors->first('header_color', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>

                <!-- Custom css -->
                <div class="form-group {{ $errors->has('custom_css') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('custom_css', trans('admin/settings/general.custom_css')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::textarea('custom_css', Input::old('custom_css', $setting->custom_css), array('class' => 'form-control','placeholder' => 'Add your custom CSS','disabled'=>'disabled')) }}
                      {!! $errors->first('custom_css', '<span class="alert-msg">:message</span>') !!}
                      <p class="help-block">{{ trans('general.lock_passwords') }}</p>
                    @else
                      {{ Form::textarea('custom_css', Input::old('custom_css', $setting->custom_css), array('class' => 'form-control','placeholder' => 'Add your custom CSS')) }}
                      {!! $errors->first('custom_css', '<span class="alert-msg">:message</span>') !!}
                    @endif
                   <p class="help-block">{{ trans('admin/settings/general.custom_css_help') }}</p>
                  </div>
                </div>

                <!-- remote load -->
                <div class="form-group">
                  <div class="col-md-3">
                  {{ Form::label('load_remote', trans('admin/settings/general.load_remote_text')) }}
                  </div>
                  <div class="col-md-9">
                  {{ Form::checkbox('load_remote', '1', Input::old('load_remote', $setting->load_remote),array('class' => 'minimal')) }}
                            {{ trans('admin/settings/general.load_remote_help_text') }}
                  </div>
                </div>

                <!-- Per Page -->
                <div class="form-group {{ $errors->has('per_page') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('per_page', trans('admin/settings/general.per_page')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::text('per_page', Input::old('per_page', $setting->per_page), array('class' => 'form-control','placeholder' => '5', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                    {!! $errors->first('per_page', '<span class="alert-msg">:message</span>') !!}
                  </div>
                </div>


              </div>
            </div>
          </div>
          <div class="panel box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="accordion-header">
                    <i class="fa fa-hashtag"></i> {{ trans('admin/settings/general.asset_ids') }}
                  </a>
                </h4>
            </div>

            <div id="collapseTwo" class="box-collapse collapse" role="tabbox" aria-labelledby="headingTwo">
              <div class="box-body">
                <!-- auto ids -->
                <div class="form-group">
                  <div class="col-md-3">
                  {{ Form::label('auto_increment_assets', trans('admin/settings/general.asset_ids')) }}
                  </div>
                  <div class="col-md-9">
                  {{ Form::checkbox('auto_increment_assets', '1', Input::old('auto_increment_assets', $setting->auto_increment_assets),array('class' => 'minimal')) }}
                            {{ trans('admin/settings/general.auto_increment_assets') }}
                  </div>
                </div>

                <!-- auto prefix -->
                <div class="form-group {{ $errors->has('auto_increment_prefix') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('auto_increment_prefix', trans('admin/settings/general.auto_increment_prefix')) }}
                  </div>
                  <div class="col-md-9">
                    @if ($setting->auto_increment_assets == 1)
                    {{ Form::text('auto_increment_prefix', Input::old('auto_increment_prefix', $setting->auto_increment_prefix), array('class' => 'form-control', 'style'=>'width: 100px;')) }}
                    {!! $errors->first('auto_increment_prefix', '<span class="alert-msg">:message</span>') !!}
                    @else
                    {{ Form::text('auto_increment_prefix', Input::old('auto_increment_prefix', $setting->auto_increment_prefix), array('class' => 'form-control', 'disabled'=>'disabled', 'style'=>'width: 100px;')) }}
                    @endif
                  </div>
                </div>

                <!-- auto zerofill -->
                <div class="form-group {{ $errors->has('zerofill_count') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('auto_increment_prefix', trans('admin/settings/general.zerofill_count')) }}
                  </div>
                  <div class="col-md-9">
                      {{ Form::text('zerofill_count', Input::old('zerofill_count', $setting->zerofill_count), array('class' => 'form-control', 'style'=>'width: 100px;')) }}
                      {!! $errors->first('zerofill_count', '<span class="alert-msg">:message</span>') !!}

                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="panel box box-primary">
              <div class="box-header with-border">
                  <h4 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="accordion-header">
                    <i class="fa fa-barcode"></i>
                    {{ trans('admin/settings/general.barcode_settings') }}

                    </a>
                  </h4>
              </div>

            <div id="collapseThree" class="box-collapse collapse" role="tabbox" aria-labelledby="headingThree">
              <div class="box-body">
                @if ($is_gd_installed)

                  <!-- qr code -->
                  <div class="form-group">
                    <div class="col-md-3">
                      {{ Form::label('qr_code', trans('admin/settings/general.display_qr')) }}
                    </div>
                    <div class="col-md-9">
                      {{ Form::checkbox('qr_code', '1', Input::old('qr_code', $setting->qr_code),array('class' => 'minimal')) }}
                      {{ trans('general.yes') }}
                    </div>
                  </div>

                  <!-- square barcode type -->
                  <div class="form-group{{ $errors->has('barcode_type') ? ' has-error' : '' }}">
                    <div class="col-md-3">
                      {{ Form::label('barcode_type', trans('admin/settings/general.barcode_type')) }}
                    </div>
                    <div class="col-md-9">
                      {!! Form::barcode_types('barcode_type', Input::old('barcode_type', $setting->barcode_type), 'select2') !!}
                      {!! $errors->first('barcode_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                  </div>

                    <!-- barcode -->
                    <div class="form-group">
                      <div class="col-md-3">
                        {{ Form::label('qr_code', trans('admin/settings/general.display_alt_barcode')) }}
                      </div>
                      <div class="col-md-9">
                        {{ Form::checkbox('alt_barcode_enabled', '1', Input::old('alt_barcode_enabled', $setting->alt_barcode_enabled),array('class' => 'minimal')) }}
                        {{ trans('general.yes') }}
                      </div>
                    </div>

                    <!-- barcode type -->
                    <div class="form-group{{ $errors->has('alt_barcode') ? ' has-error' : '' }}">
                      <div class="col-md-3">
                        {{ Form::label('alt_barcode', trans('admin/settings/general.alt_barcode_type')) }}
                      </div>
                      <div class="col-md-9">
                        {!! Form::alt_barcode_types('alt_barcode', Input::old('alt_barcode', $setting->alt_barcode), 'select2') !!}
                        {!! $errors->first('barcode_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                      </div>
                    </div>

                @else
                  <span class="help-block col-md-offset-3 col-md-12">
                    {{ trans('admin/settings/general.php_gd_warning') }}
                    <br>
                    {{ trans('admin/settings/general.php_gd_info') }}
                  </span>
                @endif

              </div>
            </div>
          </div>

          <div class="panel box box-primary">

              <div class="box-header with-border">
                  <h4 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" class="accordion-header">
                    <i class="fa fa-table"></i>
                    Labels

                    </a>
                  </h4>
              </div>

            <div id="collapseSeven" class="box-collapse collapse" role="tabbox" aria-labelledby="headingSeven">
              <div class="box-body">


                <!-- qr text -->
                <div class="form-group {{ $errors->has('qr_text') ? 'error' : '' }}">
                  <div class="col-md-3">
                  {{ Form::label('qr_text', trans('admin/settings/general.qr_text')) }}
                  </div>
                  <div class="col-md-9">
                  @if ($setting->qr_code == 1)
                    {{ Form::text('qr_text', Input::old('qr_text', $setting->qr_text), array('class' => 'form-control','placeholder' => 'Property of Your Company',
                    'rel' => 'txtTooltip',
                    'title' =>'Extra text that you would like to display on your labels. ',
                    'data-toggle' =>'tooltip',
                    'data-placement'=>'top')) }}
                    {!! $errors->first('qr_text', '<span class="alert-msg">:message</span>') !!}
                  @else
                    {{ Form::text('qr_text', Input::old('qr_text', $setting->qr_text), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'Property of Your Company')) }}
                    <p class="help-block">{{ trans('admin/settings/general.qr_help') }}</p>
                  @endif
                  </div>
                </div>

                  <div class="form-group {{ $errors->has('labels_per_page') ? 'error' : '' }}">
                    <div class="col-md-3">
                    {{ Form::label('labels_per_page', trans('admin/settings/general.labels_per_page')) }}
                    </div>
                    <div class="col-md-9">
                      {{ Form::text('labels_per_page', Input::old('labels_per_page', $setting->labels_per_page), array('class' => 'form-control','style' => 'width: 100px;')) }}
                      {!! $errors->first('labels_per_page', '<span class="alert-msg">:message</span>') !!}
                    </div>
                  </div>

                  <div class="form-group {{ $errors->has('labels_width') ? 'error' : '' }}">
                    <div class="col-md-3">
                    {{ Form::label('labels_width', trans('admin/settings/general.labels_fontsize')) }}
                    </div>
                    <div class="col-md-2 form-group">
                      <div class="input-group">
                        {{ Form::text('labels_fontsize', Input::old('labels_fontsize', $setting->labels_fontsize), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.text_pt') }}</div>
                      </div>
                    </div>
                    <div class="col-md-9 col-md-offset-3">
                      {!! $errors->first('labels_fontsize', '<span class="alert-msg">:message</span>') !!}
                    </div>
                  </div>



                  <div class="form-group {{ $errors->has('labels_width') ? 'error' : '' }}">
                    <div class="col-md-3">
                    {{ Form::label('labels_width', trans('admin/settings/general.label_dimensions')) }}
                    </div>
                    <div class="col-md-3 form-group">
                      <div class="input-group">
                        {{ Form::text('labels_width', Input::old('labels_width', $setting->labels_width), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.width_w') }}</div>
                      </div>
                    </div>
                    <div class="col-md-3 form-group" style="margin-left: 10px">
                      <div class="input-group">
                        {{ Form::text('labels_height', Input::old('labels_height', $setting->labels_height), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.height_h') }}</div>
                      </div>
                    </div>
                    <div class="col-md-9 col-md-offset-3">
                      {!! $errors->first('labels_width', '<span class="alert-msg">:message</span>') !!}
                      {!! $errors->first('labels_height', '<span class="alert-msg">:message</span>') !!}
                    </div>
                  </div>


                  <div class="form-group {{ $errors->has('labels_width') ? 'error' : '' }}">
                    <div class="col-md-3">
                    {{ Form::label('labels_width', trans('admin/settings/general.label_gutters')) }}
                    </div>
                    <div class="col-md-3 form-group">
                      <div class="input-group">
                        {{ Form::text('labels_display_sgutter', Input::old('labels_display_sgutter', $setting->labels_display_sgutter), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.horizontal') }}</div>
                      </div>
                    </div>
                    <div class="col-md-3 form-group" style="margin-left: 10px">
                      <div class="input-group">
                        {{ Form::text('labels_display_bgutter', Input::old('labels_display_bgutter', $setting->labels_display_bgutter), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.vertical') }}</div>
                      </div>
                    </div>
                    <div class="col-md-9 col-md-offset-3">
                      {!! $errors->first('labels_display_sgutter', '<span class="alert-msg">:message</span>') !!}
                      {!! $errors->first('labels_display_bgutter', '<span class="alert-msg">:message</span>') !!}
                    </div>
                  </div>



                  <div class="form-group {{ $errors->has('labels_width') ? 'error' : '' }}">
                    <div class="col-md-3">
                    {{ Form::label('labels_width', trans('admin/settings/general.page_padding')) }}
                    </div>
                    <div class="col-md-3 form-group">
                      <div class="input-group" style="margin-bottom: 15px;">
                        {{ Form::text('labels_pmargin_top', Input::old('labels_pmargin_top', $setting->labels_pmargin_top), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.top') }}</div>
                      </div>

                      <div class="input-group">
                        {{ Form::text('labels_pmargin_right', Input::old('labels_pmargin_right', $setting->labels_pmargin_right), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.right') }}</div>
                      </div>

                    </div>
                    <div class="col-md-3 form-group" style="margin-left: 10px; ">
                      <div class="input-group" style="margin-bottom: 15px;">
                        {{ Form::text('labels_pmargin_bottom', Input::old('labels_pmargin_bottom', $setting->labels_pmargin_bottom), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.bottom') }}</div>
                      </div>
                      <div class="input-group">
                        {{ Form::text('labels_pmargin_left', Input::old('labels_pmargin_left', $setting->labels_pmargin_left), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.left') }}</div>
                      </div>
                    </div>
                    <div class="col-md-9 col-md-offset-3">
                      {!! $errors->first('labels_width', '<span class="alert-msg">:message</span>') !!}
                      {!! $errors->first('labels_height', '<span class="alert-msg">:message</span>') !!}
                    </div>
                  </div>

                  <div class="form-group {{ $errors->has('labels_pageheight') ? 'error' : '' }}">
                    <div class="col-md-3">
                    {{ Form::label('labels_width', trans('admin/settings/general.page_dimensions')) }}
                    </div>
                    <div class="col-md-3 form-group">
                      <div class="input-group">
                        {{ Form::text('labels_pagewidth', Input::old('labels_pagewidth', $setting->labels_pagewidth), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.width_w') }}</div>
                      </div>
                    </div>
                    <div class="col-md-3 form-group" style="margin-left: 10px">
                      <div class="input-group">
                        {{ Form::text('labels_pageheight', Input::old('labels_pageheight', $setting->labels_pageheight), array('class' => 'form-control')) }}
                        <div class="input-group-addon">{{ trans('admin/settings/general.height_h') }}</div>
                      </div>
                    </div>
                    <div class="col-md-9 col-md-offset-3">
                      {!! $errors->first('labels_pagewidth', '<span class="alert-msg">:message</span>') !!}
                      {!! $errors->first('labels_pageheight', '<span class="alert-msg">:message</span>') !!}
                    </div>
                  </div>


                  <div class="form-group">
                    <div class="col-md-3">
                    {{ Form::label('labels_width', trans('admin/settings/general.label_fields')) }}
                    </div>
                    <div class="col-md-9">
                      <div class="checkbox">
                        <label>
                          {{ Form::checkbox('labels_display_name', '1', Input::old('labels_display_name',   $setting->labels_display_name),array('class' => 'minimal')) }}
                          {{ trans('admin/hardware/form.name') }}
                        </label>
                        <label>
                          {{ Form::checkbox('labels_display_serial', '1', Input::old('labels_display_serial',   $setting->labels_display_serial),array('class' => 'minimal')) }}
                          {{ trans('admin/hardware/form.serial') }}
                        </label>

                        <label>
                          {{ Form::checkbox('labels_display_tag', '1', Input::old('labels_display_tag',   $setting->labels_display_tag),array('class' => 'minimal')) }}
                          {{ trans('admin/hardware/form.tag') }}
                        </label>

                      </div>
                    </div>
                  </div>





              </div>
            </div>
          </div>

        <div class="panel box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="accordion-header">
                  <i class="fa fa-file-text-o"></i>
                  {{ trans('admin/settings/general.default_eula_text') }}

                  </a>
                </h4>
            </div>

          <div id="collapseFour" class="box-collapse collapse" role="tabbox" aria-labelledby="headingFour">
            <div class="box-body">
              <div class="form-group {{ $errors->has('default_eula_text') ? 'error' : '' }}">
                <div class="col-md-12">
                  {{ Form::textarea('default_eula_text', Input::old('default_eula_text', $setting->default_eula_text), array('class' => 'form-control','placeholder' => 'Add your default EULA text')) }}
                  {!! $errors->first('default_eula_text', '<span class="alert-msg">:message</span>') !!}
                  <p class="help-block">{{ trans('admin/settings/general.default_eula_help_text') }}</p>
                  <p class="help-block">{!! trans('admin/settings/general.eula_markdown') !!}</p>
                </div>
              </div>

            </div>
          </div>

        </div>


        <div class="panel box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive" class="accordion-header">
                  <i class="fa fa-slack"></i>
                  {{ trans('admin/settings/general.slack_integration') }}

                  </a>
                </h4>
            </div>
          <div id="collapseFive" class="box-collapse collapse" role="tabbox" aria-labelledby="headingFive">
            <div class="box-body">
              <p class="help-block">{!! trans('admin/settings/general.slack_integration_help',array('slack_link' => 'https://my.slack.com/services/new/incoming-webhook')) !!}</p>

              <!-- slack endpoint -->
              <div class="form-group {{ $errors->has('slack_endpoint') ? 'error' : '' }}">
                <div class="col-md-3">
                  {{ Form::label('slack_endpoint', trans('admin/settings/general.slack_endpoint')) }}
                </div>
                <div class="col-md-9">
                @if (config('app.lock_passwords')===true)
                  {{ Form::text('slack_endpoint', Input::old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','disabled'=>'disabled','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX')) }}
                @else
                  {{ Form::text('slack_endpoint', Input::old('slack_endpoint', $setting->slack_endpoint), array('class' => 'form-control','placeholder' => 'https://hooks.slack.com/services/XXXXXXXXXXXXXXXXXXXXX')) }}
                @endif
                {!! $errors->first('slack_endpoint', '<span class="alert-msg">:message</span>') !!}
                </div>
              </div>

              <!-- slack channel -->
              <div class="form-group {{ $errors->has('slack_channel') ? 'error' : '' }}">
                <div class="col-md-3">
                  {{ Form::label('slack_channel', trans('admin/settings/general.slack_channel')) }}
                </div>
                <div class="col-md-9">
                @if (config('app.lock_passwords')===true)
                  {{ Form::text('slack_channel', Input::old('slack_channel', $setting->slack_channel), array('class' => 'form-control','disabled'=>'disabled','placeholder' => '#IT-Ops')) }}
                @else
                  {{ Form::text('slack_channel', Input::old('slack_channel', $setting->slack_channel), array('class' => 'form-control','placeholder' => '#IT-Ops')) }}
                @endif
                {!! $errors->first('slack_channel', '<span class="alert-msg">:message</span>') !!}
                </div>
              </div>


            </div>
          </div>
        </div>

        <div class="panel box box-primary">
            <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix" class="accordion-header">
                  <i class="fa fa-envelope-o"></i>
                  {{ trans('admin/settings/general.ldap_settings') }}

                  </a>
                </h4>
            </div>
          <div id="collapseSix" class="box-collapse collapse" role="tabbox" aria-labelledby="headingSix">
            <div class="box-body">
              <!-- Enable LDAP -->
              <div class="form-group {{ $errors->has('ldap_integration') ? 'error' : '' }}">
                <div class="col-md-3">
                  {{ Form::label('ldap_integration', trans('admin/settings/general.ldap_integration')) }}
                </div>
                <div class="col-md-9">
                  {{ Form::checkbox('ldap_enabled', '1', Input::old('ldap_enabled', $setting->ldap_enabled),array('class' => 'minimal')) }}
                  {{ trans('admin/settings/general.ldap_enabled') }}
                  {!! $errors->first('ldap_enabled', '<span class="alert-msg">:message</span>') !!}
                </div>
              </div>


              <!-- AD Flag -->
              <div class="form-group">
                <div class="col-md-3">
                  {{ Form::label('is_ad', trans('admin/settings/general.ad')) }}
                </div>
                <div class="col-md-9">
                  {{ Form::checkbox('is_ad', '1', Input::old('is_ad', $setting->is_ad),array('class' => 'minimal')) }}
                  {{ trans('admin/settings/general.is_ad') }}
                  {!! $errors->first('is_ad', '<span class="alert-msg">:message</span>') !!}

                </div>
              </div>
              <!-- /.form-group -->

              <!-- LDAP Password Sync -->
              <div class="form-group">
                <div class="col-md-3">
                  {{ Form::label('is_ad', trans('admin/settings/general.ldap_pw_sync')) }}
                </div>
                <div class="col-md-9">
                  {{ Form::checkbox('ldap_pw_sync', '1', Input::old('ldap_pw_sync', $setting->ldap_pw_sync),array('class' => 'minimal')) }}
                  {{ trans('general.yes') }}
                  <p class="help-block">{{ trans('admin/settings/general.ldap_pw_sync_help') }}</p>
                  {!! $errors->first('ldap_pw_sync', '<span class="alert-msg">:message</span>') !!}

                </div>
              </div>
              <!-- /.form-group -->

              <!-- AD Domain -->
              <div class="form-group {{ $errors->has('ad_domain') ? 'error' : '' }}">
                <div class="col-md-3">
                  {{ Form::label('ad_domain', trans('admin/settings/general.ad_domain')) }}
                </div>
                <div class="col-md-9">
                  @if (config('app.lock_passwords')===true)
                    {{ Form::text('ad_domain', Input::old('ad_domain', $setting->ad_domain), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'example.com')) }}
                  @else
                    {{ Form::text('ad_domain', Input::old('ad_domain', $setting->ad_domain), array('class' => 'form-control','placeholder' => 'example.com')) }}
                  @endif

                    <p class="help-block">{{ trans('admin/settings/general.ad_domain_help') }}</p>


                    {!! $errors->first('ad_domain', '<span class="alert-msg">:message</span>') !!}
                </div>
              </div><!-- LDAP Server -->


              <!-- LDAP Server -->
              <div class="form-group {{ $errors->has('ldap_server') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_server', trans('admin/settings/general.ldap_server')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_server', Input::old('ldap_server', $setting->ldap_server), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'ldap://ldap.example.com')) }}
                    @else
                      {{ Form::text('ldap_server', Input::old('ldap_server', $setting->ldap_server), array('class' => 'form-control','placeholder' => 'ldap://ldap.example.com')) }}
                    @endif
                      <p class="help-block">{{ trans('admin/settings/general.ldap_server_help') }}</p>
                    {!! $errors->first('ldap_server', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div><!-- LDAP Server -->


                <!-- Start TLS -->
                <div class="form-group">
                    <div class="col-md-3">
                        {{ Form::label('ldap_tls', trans('admin/settings/general.ldap_tls')) }}
                    </div>
                    <div class="col-md-9">
                        {{ Form::checkbox('ldap_tls', '1', Input::old('ldap_tls', $setting->ldap_tls),array('class' => 'minimal')) }}
                        {{ trans('admin/settings/general.ldap_tls_help') }}
                        {!! $errors->first('ldap_tls', '<span class="alert-msg">:message</span>') !!}

                    </div>
                </div>
                <!-- /.form-group -->


              <div class="form-group {{ $errors->has('ldap_server_cert_ignore') ? 'error' : '' }}">
                  <div class="col-md-3">
                     {{ Form::label('ldap_server_cert_ignore', trans('admin/settings/general.ldap_server_cert')) }}
                  </div>
                  <div class="col-md-9">
                    {{ Form::checkbox('ldap_server_cert_ignore', '1', Input::old('ldap_server_cert_ignore', $setting->ldap_server_cert_ignore),array('class' => 'minimal')) }}
                    {{ trans('admin/settings/general.ldap_server_cert_ignore') }}
                    {!! $errors->first('ldap_server_cert_ignore', '<span class="alert-msg">:message</span>') !!}
                    <p class="help-block">{{ trans('admin/settings/general.ldap_server_cert_help') }}</p>
                  </div>
              </div>

              <!-- LDAP Username -->
              <div class="form-group {{ $errors->has('ldap_uname') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_uname', trans('admin/settings/general.ldap_uname')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_uname', Input::old('ldap_uname', $setting->ldap_uname), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'binduser@example.com')) }}
                    @else
                      {{ Form::text('ldap_uname', Input::old('ldap_uname', $setting->ldap_uname), array('class' => 'form-control','placeholder' => 'binduser@example.com')) }}
                    @endif

                    {!! $errors->first('ldap_uname', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>


              <!-- LDAP pword -->
              <div class="form-group {{ $errors->has('ldap_pword') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_pword', trans('admin/settings/general.ldap_pword')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords'))
                      {{ Form::password('ldap_pword', array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'binduserpassword')) }}
                    @else
                      {{ Form::password('ldap_pword', array('class' => 'form-control','placeholder' => 'binduserpassword')) }}
                    @endif

                    {!! $errors->first('ldap_pword', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>


              <!-- LDAP basedn -->
              <div class="form-group {{ $errors->has('ldap_basedn') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_basedn', trans('admin/settings/general.ldap_basedn')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_basedn', Input::old('ldap_basedn', $setting->ldap_basedn), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'cn=users/authorized,dc=example,dc=com')) }}
                    @else
                      {{ Form::text('ldap_basedn', Input::old('ldap_basedn', $setting->ldap_basedn), array('class' => 'form-control','placeholder' => 'cn=users/authorized,dc=example,dc=com')) }}
                    @endif

                    {!! $errors->first('ldap_basedn', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>

              <!-- LDAP filter -->
              <div class="form-group {{ $errors->has('ldap_filter') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_filter', trans('admin/settings/general.ldap_filter')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_filter', Input::old('ldap_filter', $setting->ldap_filter), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '&(cn=*)')) }}
                    @else
                      {{ Form::text('ldap_filter', Input::old('ldap_filter', $setting->ldap_filter), array('class' => 'form-control','placeholder' => '&(cn=*)')) }}
                    @endif

                    {!! $errors->first('ldap_filter', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>


              <!-- LDAP  username field-->
              <div class="form-group {{ $errors->has('ldap_username_field') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_username_field', trans('admin/settings/general.ldap_username_field')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_username_field', Input::old('ldap_username_field', $setting->ldap_username_field), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'samaccountname')) }}
                    @else
                      {{ Form::text('ldap_username_field', Input::old('ldap_username_field', $setting->ldap_username_field), array('class' => 'form-control','placeholder' => 'samaccountname')) }}
                    @endif

                    {!! $errors->first('ldap_username_field', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>


              <!-- LDAP Last Name Field -->
              <div class="form-group {{ $errors->has('ldap_lname_field') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_lname_field', trans('admin/settings/general.ldap_lname_field')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_lname_field', Input::old('ldap_lname_field', $setting->ldap_lname_field), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'sn')) }}
                    @else
                      {{ Form::text('ldap_lname_field', Input::old('ldap_lname_field', $setting->ldap_lname_field), array('class' => 'form-control','placeholder' => 'sn')) }}
                    @endif

                    {!! $errors->first('ldap_lname_field', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>


              <!-- LDAP First Name field -->
              <div class="form-group {{ $errors->has('ldap_fname_field') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_fname_field', trans('admin/settings/general.ldap_fname_field')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_fname_field', Input::old('ldap_fname_field', $setting->ldap_fname_field), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'givenname')) }}
                    @else
                      {{ Form::text('ldap_fname_field', Input::old('ldap_fname_field', $setting->ldap_fname_field), array('class' => 'form-control','placeholder' => 'givenname')) }}
                    @endif

                    {!! $errors->first('ldap_fname_field', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>

              <!-- LDAP Auth Filter Query -->
              <div class="form-group {{ $errors->has('ldap_auth_filter_query') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_auth_filter_query', trans('admin/settings/general.ldap_auth_filter_query')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_auth_filter_query', Input::old('ldap_auth_filter_query', $setting->ldap_auth_filter_query), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '"uid="')) }}
                    @else
                      {{ Form::text('ldap_auth_filter_query', Input::old('ldap_auth_filter_query', $setting->ldap_auth_filter_query), array('class' => 'form-control','placeholder' => '"uid="')) }}
                    @endif

                    {!! $errors->first('ldap_auth_filter_query', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>

              <!-- LDAP Version -->
              <div class="form-group {{ $errors->has('ldap_version') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_version', trans('admin/settings/general.ldap_version')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_version', Input::old('ldap_version', $setting->ldap_version), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '3')) }}
                    @else
                      {{ Form::text('ldap_version', Input::old('ldap_version', $setting->ldap_version), array('class' => 'form-control','placeholder' => '3')) }}
                    @endif

                    {!! $errors->first('ldap_version', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>

              <!-- LDAP active flag -->
              <div class="form-group {{ $errors->has('ldap_active_flag') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_active_flag', trans('admin/settings/general.ldap_active_flag')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_active_flag', Input::old('ldap_active_flag', $setting->ldap_active_flag), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '')) }}
                    @else
                      {{ Form::text('ldap_active_flag', Input::old('ldap_active_flag', $setting->ldap_active_flag), array('class' => 'form-control','placeholder' => '')) }}
                    @endif

                    {!! $errors->first('ldap_active_flag', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>

              <!-- LDAP emp number -->
              <div class="form-group {{ $errors->has('ldap_emp_num') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_emp_num', trans('admin/settings/general.ldap_emp_num')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_emp_num', Input::old('ldap_emp_num', $setting->ldap_emp_num), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '')) }}
                    @else
                      {{ Form::text('ldap_emp_num', Input::old('ldap_emp_num', $setting->ldap_emp_num), array('class' => 'form-control','placeholder' => '')) }}
                    @endif

                    {!! $errors->first('ldap_emp_num', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>

              <!-- LDAP email -->
              <div class="form-group {{ $errors->has('ldap_email') ? 'error' : '' }}">
                  <div class="col-md-3">
                    {{ Form::label('ldap_email', trans('admin/settings/general.ldap_email')) }}
                  </div>
                  <div class="col-md-9">
                    @if (config('app.lock_passwords')===true)
                      {{ Form::text('ldap_email', Input::old('ldap_email', $setting->ldap_email), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '')) }}
                    @else
                      {{ Form::text('ldap_email', Input::old('ldap_email', $setting->ldap_email), array('class' => 'form-control','placeholder' => '')) }}
                    @endif

                    {!! $errors->first('ldap_email', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>
            </div>
          </div>
      </div> <!-- /box body -->
      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div> <!-- /box body -->
    </div> <!-- /box -->



</form>

@section('moar_scripts')
<!-- bootstrap color picker -->
<script>
//color picker with addon
$(".header-color").colorpicker();
</script>
@stop


@stop
