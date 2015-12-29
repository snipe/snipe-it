@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/settings/general.update') ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3>@lang('admin/settings/general.update')</h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

          {{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal', 'role' => 'form' ]) }}
          <!-- CSRF Token -->
          {{ Form::hidden('_token', csrf_token()) }}



          <h4>@lang('admin/settings/general.general_settings')</h4>

          <!-- Site name -->
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

          @if (Sentry::getUser()->isSuperUser())
            <!-- Full Multiple Companies Support -->
            <div class="form-group {{ $errors->has('full_multiple_companies_support') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('full_multiple_companies_support',
                               Lang::get('admin/settings/general.full_multiple_companies_support_text')) }}
              </div>
              <div class="col-md-9">
                {{ Form::checkbox('full_multiple_companies_support', '1', Input::old('full_multiple_companies_support',
                                  $setting->full_multiple_companies_support)) }}
                @Lang('admin/settings/general.full_multiple_companies_support_text')
                {{ $errors->first('full_multiple_companies_support', '<br><span class="alert-msg">:message</span>') }}
                <p class="help-inline">@lang('admin/settings/general.full_multiple_companies_support_help_text')</p>
              </div>
            </div>
          @endif

          <!-- Logo -->
          <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
            <div class="col-md-3">
              {{ Form::label('logo', Lang::get('admin/settings/general.logo')) }}
            </div>
            <div class="col-md-9">
              @if (Config::get('app.lock_passwords'))
                  <p class="help-block">@lang('general.lock_passwords')</p>
              @else
                {{ Form::file('logo') }}
                {{ $errors->first('logo', '<br><span class="alert-msg">:message</span>') }}
                {{ Form::checkbox('clear_logo', '1', Input::old('clear_logo')) }} Remove
              @endif
            </div>
          </div>

          <!-- Branding -->
          <div class="form-group {{ $errors->has('brand') ? 'error' : '' }}">
            <div class="col-md-3">
              {{ Form::label('brand', Lang::get('admin/settings/general.brand')) }}
            </div>
            <div class="col-md-9">
              {{ Form::select('brand', array('1'=>'Text','2'=>'Logo','3'=>'Logo + Text'), Input::old('brand', $setting->brand), array('class' => 'form-control', 'style'=>'width: 150px ;')) }}
              {{ $errors->first('brand', '<br><span class="alert-msg">:message</span>') }}
            </div>
          </div>

          <!-- Currency -->
          <div class="form-group {{ $errors->has('default_currency') ? 'error' : '' }}">
            <div class="col-md-3">
              {{ Form::label('default_currency', Lang::get('admin/settings/general.default_currency')) }}
            </div>
            <div class="col-md-9">
              {{ Form::currencies('default_currency', Input::old('default_currency', $setting->default_currency),'form-control') }}
              {{ $errors->first('default_currency', '<br><span class="alert-msg">:message</span>') }}
            </div>
          </div>

          <!-- Alert Email -->
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

          <!-- Header color -->
          <div class="form-group {{ $errors->has('header_color') ? 'error' : '' }}">
            <div class="col-md-3">
              {{ Form::label('header_color', Lang::get('admin/settings/general.header_color')) }}
            </div>
            <div class="col-md-9">
              {{ Form::text('header_color', Input::old('header_color', $setting->header_color), array('class' => 'form-control', 'style' => 'width: 100px;','placeholder' => '#FF0000')) }}
              {{ $errors->first('header_color', '<br><span class="alert-msg">:message</span>') }}
            </div>
          </div>

          <!-- Custom css -->
          <div class="form-group {{ $errors->has('custom_css') ? 'error' : '' }}">
            <div class="col-md-3">
              {{ Form::label('custom_css', Lang::get('admin/settings/general.custom_css')) }}
            </div>
            <div class="col-md-9">
              @if (Config::get('app.lock_passwords')===true)
                {{ Form::textarea('custom_css', Input::old('custom_css', $setting->custom_css), array('class' => 'form-control','placeholder' => 'Add your custom CSS','disabled'=>'disabled')) }}
                {{ $errors->first('custom_css', '<br><span class="alert-msg">:message</span>') }}
                <p class="help-block">@lang('general.lock_passwords')</p>
              @else
                {{ Form::textarea('custom_css', Input::old('custom_css', $setting->custom_css), array('class' => 'form-control','placeholder' => 'Add your custom CSS')) }}
                {{ $errors->first('custom_css', '<br><span class="alert-msg">:message</span>') }}
              @endif
             <p class="help-inline">@lang('admin/settings/general.custom_css_help')</p>
            </div>
          </div>

          <!-- results per page -->
          <div class="form-group {{ $errors->has('per_page') ? 'error' : '' }}">
            <div class="col-md-3">
            {{ Form::label('per_page', Lang::get('admin/settings/general.per_page')) }}
            </div>
            <div class="col-md-9">
            {{ Form::select('per_page', array('10'=>'10','25'=>'25','50'=>'50','75'=>'75','100'=>'100','125'=>'125','150'=>'150'), Input::old('per_page', $setting->per_page), array('class' => 'form-control', 'style'=>'width: 100px;')) }}
            {{ $errors->first('per_page', '<br><span class="alert-msg">:message</span>') }}
            </div>
          </div>

          <!-- remote load -->
          <div class="form-group">
            <div class="col-md-3">
            {{ Form::label('load_remote', Lang::get('admin/settings/general.load_remote_text')) }}
            </div>
            <div class="col-md-9">
            {{ Form::checkbox('load_remote', '1', Input::old('load_remote', $setting->load_remote)) }}
                      @lang('admin/settings/general.load_remote_help_text')
            </div>
          </div>

          <hr><h4>@lang('admin/settings/general.asset_ids') (@lang('admin/settings/general.optional'))</h4>

          <!-- auto ids -->
          <div class="form-group">
            <div class="col-md-3">
            {{ Form::label('auto_increment_assets', Lang::get('admin/settings/general.asset_ids')) }}
            </div>
            <div class="col-md-9">
            {{ Form::checkbox('auto_increment_assets', '1', Input::old('auto_increment_assets', $setting->auto_increment_assets)) }}
                      @lang('admin/settings/general.auto_increment_assets')
            </div>
          </div>

          <!-- auto prefix -->
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

          <hr><h4>@lang('admin/settings/general.barcode_settings') (@lang('admin/settings/general.optional'))</h4>

            @if ($is_gd_installed)

              <!-- qr code -->
              <div class="form-group">
                <div class="col-md-3">
                {{ Form::label('qr_code', Lang::get('admin/settings/general.display_qr')) }}
                </div>
                <div class="col-md-9">
                {{ Form::checkbox('qr_code', '1', Input::old('qr_code', $setting->qr_code)) }}
                          @lang('admin/settings/general.display_qr')
                </div>
              </div>

              <!-- barcode type -->
              <div class="form-group{{ $errors->has('barcode_type') ? ' has-error' : '' }}">
                <div class="col-md-3">
                  {{ Form::label('barcode_type', Lang::get('admin/settings/general.barcode_type')) }}
                </div>
                <div class="col-md-9">
                {{ Form::barcode_types('barcode_type', Input::old('barcode_type', $setting->barcode_type), 'select2') }}
                {{ $errors->first('barcode_type', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
              </div>

              <!-- qr text -->
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
                  <p class="help-inline">@lang('admin/settings/general.qr_help')</p>
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

          <hr><h4>@lang('admin/settings/general.eula_settings') (@lang('admin/settings/general.optional'))</h4>
            <!-- EULA text -->
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

          <hr><h4>@lang('admin/settings/general.slack_integration') (@lang('admin/settings/general.optional'))</h4>
<p class="help-inline">@lang('admin/settings/general.slack_integration_help',array('slack_link' => 'https://my.slack.com/services/new/incoming-webhook'))</p>

            <!-- slack endpoint -->
            <div class="form-group {{ $errors->has('slack_endpoint') ? 'error' : '' }}">
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

            <!-- slack channel -->
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

          <hr><h4>@lang('admin/settings/general.ldap_settings') (@lang('admin/settings/general.optional'))</h4>

          <!-- Enable LDAP -->
          <div class="form-group {{ $errors->has('ldap_integration') ? 'error' : '' }}">
            <div class="col-md-3">
              {{ Form::label('ldap_integration', Lang::get('admin/settings/general.ldap_integration')) }}
            </div>
            <div class="col-md-9">
              {{ Form::checkbox('ldap_enabled', '1', Input::old('ldap_enabled', $setting->ldap_enabled)) }}
              @Lang('admin/settings/general.ldap_enabled')
              {{ $errors->first('ldap_enabled', '<br><span class="alert-msg">:message</span>') }}
            </div>
          </div>

          <!-- LDAP Server -->
          <div class="form-group {{ $errors->has('ldap_server') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_server', Lang::get('admin/settings/general.ldap_server')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_server', Input::old('ldap_server', $setting->ldap_server), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'ldap://ldap.example.com')) }}
                @else
                  {{ Form::text('ldap_server', Input::old('ldap_server', $setting->ldap_server), array('class' => 'form-control','placeholder' => 'ldap://ldap.example.com')) }}
                @endif

                {{ $errors->first('ldap_server', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div><!-- LDAP Server -->
          <div class="form-group {{ $errors->has('ldap_server_cert_ignore') ? 'error' : '' }}">
              <div class="col-md-3">
                 {{ Form::label('ldap_server_cert_ignore', Lang::get('admin/settings/general.ldap_server_cert')) }}
              </div>
              <div class="col-md-9">
                {{ Form::checkbox('ldap_server_cert_ignore', '1', Input::old('ldap_server_cert_ignore', $setting->ldap_server_cert_ignore)) }}
                @Lang('admin/settings/general.ldap_server_cert_ignore')
                {{ $errors->first('ldap_server_cert_ignore', '<br><span class="alert-msg">:message</span>') }}
                <p class="help-inline">@Lang('admin/settings/general.ldap_server_cert_help')</p>
              </div>
          </div>

          <!-- LDAP Username -->
          <div class="form-group {{ $errors->has('ldap_uname') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_uname', Lang::get('admin/settings/general.ldap_uname')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_uname', Input::old('ldap_uname', $setting->ldap_uname), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'binduser@example.com')) }}
                @else
                  {{ Form::text('ldap_uname', Input::old('ldap_uname', $setting->ldap_uname), array('class' => 'form-control','placeholder' => 'binduser@example.com')) }}
                @endif

                {{ $errors->first('ldap_uname', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>


          <!-- LDAP pword -->
          <div class="form-group {{ $errors->has('ldap_pword') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_pword', Lang::get('admin/settings/general.ldap_pword')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords'))
                  {{ Form::text('ldap_pword', Input::old('ldap_pword'), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'binduserpassword')) }}
                @else
                  {{ Form::text('ldap_pword', Input::old('ldap_pword', $show_ldap_pword), array('class' => 'form-control','placeholder' => 'binduserpassword')) }}
                @endif

                {{ $errors->first('ldap_pword', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>


          <!-- LDAP basedn -->
          <div class="form-group {{ $errors->has('ldap_basedn') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_basedn', Lang::get('admin/settings/general.ldap_basedn')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_basedn', Input::old('ldap_basedn', $setting->ldap_basedn), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'cn=users/authorized,dc=example,dc=com')) }}
                @else
                  {{ Form::text('ldap_basedn', Input::old('ldap_basedn', $setting->ldap_basedn), array('class' => 'form-control','placeholder' => 'cn=users/authorized,dc=example,dc=com')) }}
                @endif

                {{ $errors->first('ldap_basedn', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>

          <!-- LDAP filter -->
          <div class="form-group {{ $errors->has('ldap_filter') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_filter', Lang::get('admin/settings/general.ldap_filter')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_filter', Input::old('ldap_filter', $setting->ldap_filter), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'cn=users/authorized,dc=example,dc=com')) }}
                @else
                  {{ Form::text('ldap_filter', Input::old('ldap_filter', $setting->ldap_filter), array('class' => 'form-control','placeholder' => 'cn=users/authorized,dc=example,dc=com')) }}
                @endif

                {{ $errors->first('ldap_filter', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>


          <!-- LDAP  username field-->
          <div class="form-group {{ $errors->has('ldap_username_field') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_username_field', Lang::get('admin/settings/general.ldap_username_field')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_username_field', Input::old('ldap_username_field', $setting->ldap_username_field), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'samaccountname')) }}
                @else
                  {{ Form::text('ldap_username_field', Input::old('ldap_username_field', $setting->ldap_username_field), array('class' => 'form-control','placeholder' => 'samaccountname')) }}
                @endif

                {{ $errors->first('ldap_username_field', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>


          <!-- LDAP Last Name Field -->
          <div class="form-group {{ $errors->has('ldap_lname_field') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_lname_field', Lang::get('admin/settings/general.ldap_lname_field')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_lname_field', Input::old('ldap_lname_field', $setting->ldap_lname_field), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'sn')) }}
                @else
                  {{ Form::text('ldap_lname_field', Input::old('ldap_lname_field', $setting->ldap_lname_field), array('class' => 'form-control','placeholder' => 'sn')) }}
                @endif

                {{ $errors->first('ldap_lname_field', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>


          <!-- LDAP First Name field -->
          <div class="form-group {{ $errors->has('ldap_fname_field') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_fname_field', Lang::get('admin/settings/general.ldap_fname_field')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_fname_field', Input::old('ldap_fname_field', $setting->ldap_fname_field), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'givenname')) }}
                @else
                  {{ Form::text('ldap_fname_field', Input::old('ldap_fname_field', $setting->ldap_fname_field), array('class' => 'form-control','placeholder' => 'givenname')) }}
                @endif

                {{ $errors->first('ldap_fname_field', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>

          <!-- LDAP Auth Filter Query -->
          <div class="form-group {{ $errors->has('ldap_auth_filter_query') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_auth_filter_query', Lang::get('admin/settings/general.ldap_auth_filter_query')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_auth_filter_query', Input::old('ldap_auth_filter_query', $setting->ldap_auth_filter_query), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '"uid="')) }}
                @else
                  {{ Form::text('ldap_auth_filter_query', Input::old('ldap_auth_filter_query', $setting->ldap_auth_filter_query), array('class' => 'form-control','placeholder' => '"uid="')) }}
                @endif

                {{ $errors->first('ldap_auth_filter_query', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>

          <!-- LDAP Version -->
          <div class="form-group {{ $errors->has('ldap_version') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_version', Lang::get('admin/settings/general.ldap_version')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_version', Input::old('ldap_version', $setting->ldap_version), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '3')) }}
                @else
                  {{ Form::text('ldap_version', Input::old('ldap_version', $setting->ldap_version), array('class' => 'form-control','placeholder' => '3')) }}
                @endif

                {{ $errors->first('ldap_version', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>

          <!-- LDAP active flag -->
          <div class="form-group {{ $errors->has('ldap_active_flag') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_active_flag', Lang::get('admin/settings/general.ldap_active_flag')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_active_flag', Input::old('ldap_active_flag', $setting->ldap_active_flag), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '')) }}
                @else
                  {{ Form::text('ldap_active_flag', Input::old('ldap_active_flag', $setting->ldap_active_flag), array('class' => 'form-control','placeholder' => '')) }}
                @endif

                {{ $errors->first('ldap_active_flag', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>

          <!-- LDAP emp number -->
          <div class="form-group {{ $errors->has('ldap_emp_num') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_emp_num', Lang::get('admin/settings/general.ldap_emp_num')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_emp_num', Input::old('ldap_emp_num', $setting->ldap_emp_num), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '')) }}
                @else
                  {{ Form::text('ldap_emp_num', Input::old('ldap_emp_num', $setting->ldap_emp_num), array('class' => 'form-control','placeholder' => '')) }}
                @endif

                {{ $errors->first('ldap_emp_num', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>

          <!-- LDAP email -->
          <div class="form-group {{ $errors->has('ldap_email') ? 'error' : '' }}">
              <div class="col-md-3">
                {{ Form::label('ldap_email', Lang::get('admin/settings/general.ldap_email')) }}
              </div>
              <div class="col-md-9">
                @if (Config::get('app.lock_passwords')===true)
                  {{ Form::text('ldap_email', Input::old('ldap_email', $setting->ldap_email), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => '')) }}
                @else
                  {{ Form::text('ldap_email', Input::old('ldap_email', $setting->ldap_email), array('class' => 'form-control','placeholder' => '')) }}
                @endif

                {{ $errors->first('ldap_email', '<br><span class="alert-msg">:message</span>') }}
              </div>
          </div>


          <!-- Form actions -->
          <div class="form-group">
              <div class="controls col-md-offset-3">
                  <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                  <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
              </div>
          </div>

          </form>



</div>


        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <br /><br />
            <h6>@lang('admin/settings/general.about_settings_title')</h6>
            <p>@lang('admin/settings/general.about_settings_text')</p>

                    </div>

</div>
@stop
