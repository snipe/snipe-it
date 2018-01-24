@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.admin') }}
@parent
@stop

{{-- Page content --}}
@section('content')



  <div class="row">

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.branding.index') }}" class="btn btn-lg btn-white"><i class="fa fa-copyright fa-3x"></i></a>
          <br>
          Branding
          <p class="help-block">Logo, Site Name</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.general.index') }}" class="btn btn-lg btn-white"><i class="fa fa-wrench fa-3x"></i></a>
          <br>
          General Settings
          <p class="help-block">Default EULA and more</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.security.index') }}" class="btn btn-lg btn-white"><i class="fa fa-lock fa-3x"></i></a>
          <br>
          Security
          <p class="help-block">Two-factor, Password Restrictions</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('groups.index') }}" class="btn btn-lg btn-white"><i class="fa fa-group fa-3x"></i></a>
          <br>
          Groups
          <p class="help-block">Account permission groups</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.localization.index') }}" class="btn btn-lg btn-white"><i class="fa fa-globe fa-3x"></i></a>
          <br>
          Localization
          <p class="help-block">Language, date display</p>

        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.alerts.index') }}" class="btn btn-lg btn-white"><i class="fa fa-bell fa-3x"></i></a>
          <br>
          Notifications
          <p class="help-block">Email alerts</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.slack.index') }}" class="btn btn-lg btn-white"><i class="fa fa-slack fa-3x"></i></a>
          <br>
          Slack
          <p class="help-block">Slack settings</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.asset_tags.index') }}" class="btn btn-lg btn-white"><i class="fa fa-list-ol fa-3x"></i></a>
          <br>
          Asset Tags
          <p class="help-block">Incrementing and prefixes</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.barcodes.index') }}" class="btn btn-lg btn-white"><i class="fa fa-barcode fa-3x"></i></a>
          <br>
          Barcodes
          <p class="help-block">Barcode &amp; QR settings</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.labels.index') }}" class="btn btn-lg btn-white"><i class="fa fa-tags fa-3x"></i></a>
          <br>
          Labels
          <p class="help-block">Label sizes &amp; settings</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.ldap.index') }}" class="btn btn-lg btn-white"><i class="fa fa-sitemap fa-3x"></i></a>
          <br>
          LDAP
          <p class="help-block">LDAP/Active Directory</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.backups.index') }}" class="btn btn-lg btn-white"><i class="fa fa-cloud-download fa-3x"></i></a>
          <br>
          Backups
          <p class="help-block">Download files &amp; Data</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.oauth.index') }}" class="btn btn-lg btn-white"><i class="fa fa-user-secret fa-3x"></i></a>
          <br>
          OAuth
          <p class="help-block">Oauth Endpoint Settings</p>
        </div>
      </div>
    </div>

    @if (config('app.debug')=== true)
      <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
        <div class="box box-default">
          <div class="box-body text-center">
            <a href="{{ route('settings.phpinfo.index') }}" class="btn btn-lg btn-white"><i class="fa fa-server fa-3x"></i></a>
            <br>
            PHP
            <p class="help-block">PHP System Info</p>
          </div>
        </div>
      </div>
    @endif

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-danger">
        <div class="box-body text-center">
          <a href="{{ route('settings.purge.index') }}" class="btn btn-lg btn-white text-danger"><i class="fa fa-trash fa-3x"></i></a>
          <br>
          Purge
          <p class="help-block">Purge Deleted Records</p>
        </div>
      </div>
    </div>

  </div>










<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">{{ trans('admin/settings/general.system') }}</h3>
      </div>
      <div class="box-body">
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
                <td>{{ trans('admin/settings/general.license') }}</td>
                <td>
                  <a href="https://www.gnu.org/licenses/agpl-3.0.en.html" rel="noopener">AGPL3</a>
                </td>
              </tr>
              <tr>
                <td>{{ trans('admin/settings/general.php') }}</td>
                <td> {{ phpversion() }}</td>
              </tr>
              <tr>
                <td>{{ trans('admin/settings/general.laravel') }}</td>
                <td>
                    {{ $snipeSettings->lar_ver() }}
                </td>
              </tr>




            </tbody>
          </table>
        </div>
      </div> <!-- /box-body-->
    </div> <!--/box-default-->
  </div><!--/col-md-8-->
</div><!--/row-->



@stop


