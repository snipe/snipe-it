@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.settings') }}
@parent
@stop



{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">{{ trans('admin/settings/general.general_settings') }}</h3>
        <div class="box-tools pull-right">
          <a href="{{ route('edit/settings') }}" class="btn btn-warning"><i class="fa fa-pencil icon-white"></i> {{ trans('button.edit') }} {{ trans('admin/settings/general.settings') }}</a>
        </div>
      </div>
      <div class="box-body">





        <div class="table-responsive">
          <table class="table table-striped">



              <tbody>
                  @foreach ($settings as $setting)
                  <tr>
                      <td class="col-md-4">{{ trans('admin/settings/general.site_name') }}</td>
                      <td class="col-md-8">{{ $setting->site_name }} </td>
                  </tr>
                  <tr>
                      <td>
                          {{ trans('admin/settings/general.full_multiple_companies_support_text') }}
                      </td>

                      @if ($setting->full_multiple_companies_support == 1)
                          <td>{{ trans('general.yes') }}</td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>
                  <tr>
                      <td>{{ trans('admin/settings/general.two_factor_enabled_text') }}</td>

                      @if ($setting->two_factor_enabled == '')
                          <td>{{ trans('admin/settings/general.two_factor_disabled') }}</td>
                      @elseif ($setting->two_factor_enabled == '1')
                          <td>{{ trans('admin/settings/general.two_factor_optional') }}</td>
                      @elseif ($setting->two_factor_enabled == '2')
                          <td>{{ trans('admin/settings/general.two_factor_required') }}</td>
                      @endif
                  </tr>
                  <tr>
                      <td>{{ trans('admin/settings/general.default_currency') }}</td>
                      <td>{{ $setting->default_currency }} </td>
                  </tr>
                   <tr>
                      <td>{{ trans('admin/settings/general.alert_email') }}</td>

                      @if ($setting->alert_email)
                          <td>{{ $setting->alert_email }}</td>
                      @else
                          <td>--</td>
                      @endif
                  </tr>
                  <tr>
                      <td>{{ trans('admin/settings/general.alerts_enabled') }}</td>

                      @if ($setting->alerts_enabled == 1)
                          <td>{{ trans('general.yes') }}</td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>

                   <tr>
                      <td>{{ trans('admin/settings/general.header_color') }}</td>

                      @if ($setting->header_color)
                          <td>{{ $setting->header_color }}</td>
                      @else
                          <td>default</td>
                      @endif
                  </tr>
                  <tr>
                      <td>{{ trans('admin/settings/general.auto_increment_assets') }}</td>

                      @if ($setting->auto_increment_assets == 1)
                          <td>{{ trans('general.yes') }}</td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>

                  <tr>
                      <td>{{ trans('admin/settings/general.require_accept_signature') }}</td>

                      @if ($setting->require_accept_signature == 1)
                          <td>{{ trans('general.yes') }}</td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>

                  <tr>
                      <td>{{ trans('admin/settings/general.load_remote_text') }}</td>

                      @if ($setting->load_remote == 1)
                          <td>{{ trans('general.yes') }}</td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>

                  <tr>
                      <td>{{ trans('admin/settings/general.auto_increment_prefix') }}</td>
                      <td>{{ $setting->auto_increment_prefix }}</td>
                  </tr>


                  <tr>
                      <td>{{ trans('admin/settings/general.per_page') }}</td>
                      <td>{{ $setting->per_page }}  </td>
                  </tr>
                  <tr>
                      <td>{{ trans('admin/settings/general.display_qr') }}</td>
                          @if ($setting->qr_code == 1)
                              <td>{{ trans('general.yes') }}
                              	({{ $setting->barcode_type }})
                                {{ $setting->qr_text }}

                              </td>
                          @else
                              <td>{{ trans('general.no') }}</td>
                          @endif
                  </tr>
                  <tr>
                      <td>{{ trans('admin/settings/general.default_eula_text') }}</td>

                      @if ($setting->default_eula_text!='')
                          <td>{{ trans('general.yes') }}</td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>
                  <tr>
                     <td>{{ trans('admin/settings/general.slack_integration') }} </td>

                      @if ($setting->slack_endpoint!='')
                          <td>{{ trans('general.yes') }}

                              @if ($setting->slack_channel!='')
                                  {{ $setting->slack_channel }}
                              @endif

                          </td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>
                  <tr>
                      <td>{{ trans('admin/settings/general.ldap_integration') }}</td>

                      @if ($setting->ldap_enabled == 1)
                          <td>
                              {{ $setting->ldap_server }}
                          @if ($setting->is_ad == '1')
                                (Active Directory)
                          @endif
                          </td>
                      @else
                          <td>{{ trans('general.no') }}</td>
                      @endif
                  </tr>
                  @if ($setting->ldap_enabled == 1)
                  <tr id="ldaptestrow">
                      <td class="col-md-4">Test LDAP Connection</td>
                      <td class="col-md-8">

                         <a class="btn btn-default btn-sm pull-left" id="ldaptest" style="margin-right: 10px;"> Test LDAP</a>

                          <span id="ldaptesticon">
                          </span>
                          <span id="ldaptestresult">
                          </span>
                          <span id="ldapteststatus">
                          </span>
                      </td>
                  </tr>
                  @endif


                  @endforeach
              </tbody>
          </table>

          <h4>{{ trans('admin/settings/general.system') }}</h4>
            <div class="table-responsive">
              <table class="table table-striped">
                  <tbody>
                    <tr>
                          <td class="col-md-4">{{ trans('admin/settings/general.snipe_version') }}</td>
                          <td class="col-md-8">
                              {{ config('version.app_version') }}  build {{ config('version.build_version') }} ({{ config('version.hash_version') }})
                          </td>
                      </tr>
                      <tr>
                          <td>{{ trans('admin/settings/general.php') }}</td>
                          <td> {{ phpversion() }}</td>
                      </tr>
                      <tr>
                          <td>{{ trans('admin/settings/general.laravel') }}</td>
                          <td>
                              {{ $setting->lar_ver() }}
                          </td>
                      </tr>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
  </div>
</div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-warning"></i> {{ trans('admin/settings/general.purge') }}</h3>
                </div>
                {{ Form::open(['method' => 'POST', 'route' => ['purge'], 'class' => 'form-horizontal', 'role' => 'form' ]) }}
                <!-- CSRF Token -->
                {{ Form::hidden('_token', csrf_token()) }}
                <div class="box-body">
                    <p>{{ trans('admin/settings/general.confirm_purge_help') }}</p>



                    <div class="col-md-3{{ $errors->has('confirm_purge') ? 'error' : '' }}">
                      {{ Form::label('confirm_purge', trans('admin/settings/general.confirm_purge')) }}
                    </div>
                    <div class="col-md-9{{ $errors->has('confirm_purge') ? 'error' : '' }}">
                        @if (config('app.lock_passwords')===true)
                          {{ Form::text('confirm_purge', Input::old('confirm_purge'), array('class' => 'form-control', 'disabled'=>'disabled')) }}
                        @else
                          {{ Form::text('confirm_purge', Input::old('confirm_purge'), array('class' => 'form-control')) }}
                        @endif

                        {!! $errors->first('ldap_version', '<span class="alert-msg">:message</span>') !!}
                    </div>


                </div>
                <div class="box-footer text-right">
                  <button type="submit" class="btn btn-danger">{{ trans('admin/settings/general.purge') }}</button>
                </div> <!-- /box body -->
                </form>
            </div>
        </div>
    </div>
@section('moar_scripts')


        <script>
            $("#ldaptest").click(function(){
                $("#ldaptestrow").removeClass('success');
                $("#ldaptestrow").removeClass('danger');
                $("#ldapteststatus").html('');
                $("#ldaptesticon").html('<i class="fa fa-spinner spin"></i>');
                $.ajax({
                    url: '{{ route('settings/ldaptest') }}',
                    type: 'GET',
                    data: {},
                    dataType: 'json',

                    success: function (data) {
                        // console.dir(data);
                        //console.log(data.responseJSON.message);
                        $("#ldaptesticon").html('');
                        $("#ldaptestrow").addClass('success');
                        $("#ldapteststatus").html('<i class="fa fa-check text-success"></i> It worked!');
                        //$('#ldapteststatus').html('<i class="fa fa-check text-success"></i>');
                    },

                    error: function (data) {
                        //console.dir(data);
                        //console.log(data.responseJSON.message);
                        $("#ldaptesticon").html('');
                        $("#ldaptestrow").addClass('danger');
                        $("#ldaptesticon").html('<i class="fa fa-exclamation-triangle text-danger"></i>');
                        $('#ldapteststatus').text(data.responseJSON.message);
                    }


                });
            });



        </script>
@stop
@stop
