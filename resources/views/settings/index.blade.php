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
          <h5>
          <a href="{{ route('settings.branding.index') }}">
            <i class="fa fa-copyright fa-4x" aria-hidden="true"></i>
            <br><br>
            Branding
          </a>
          </h5>
          <p class="help-block">Logo, Site Name</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.general.index') }}">
              <i class="fa fa-wrench fa-4x" aria-hidden="true"></i>
              <br><br>
              General Settings
            </a>
          </h5>
          <p class="help-block">Default EULA and more</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.security.index') }}">
              <i class="fa fa-lock fa-4x" aria-hidden="true"></i>
              <br><br>
              Security
            </a>
          </h5>
          <p class="help-block">Two-factor, Password Restrictions</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('groups.index') }}">
              <i class="fa fa-group fa-4x" aria-hidden="true"></i>
              <br><br>
              Groups
              </a>
          </h5>
          <p class="help-block">Account permission groups</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.localization.index') }}">
              <i class="fa fa-globe fa-4x" aria-hidden="true"></i>
              <br><br>
              Localization
            </a>
          </h5>
          <p class="help-block">Language, date display</p>

        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.alerts.index') }}">
              <i class="fa fa-bell fa-4x" aria-hidden="true"></i>
              <br><br>
              Notifications
            </a>
          </h5>
          <p class="help-block">Email alerts</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.slack.index') }}">
              <i class="fa fa-slack fa-4x" aria-hidden="true"></i>
              <br><br>
              Slack
            </a>
          </h5>
          <p class="help-block">Slack settings</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.asset_tags.index') }}">
              <i class="fa fa-list-ol fa-4x" aria-hidden="true"></i>
              <br><br>
              Asset Tags
            </a>
          </h5>
          <p class="help-block">Incrementing and prefixes</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.barcodes.index') }}">
              <i class="fa fa-barcode fa-4x" aria-hidden="true"></i>
              <br><br>
              Barcodes
            </a>
          </h5>
          <p class="help-block">Barcode &amp; QR settings</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.labels.index') }}">
              <i class="fa fa-tags fa-4x" aria-hidden="true"></i>
              <br><br>
              Labels
            </a>
          </h5>
          <p class="help-block">Label sizes &amp; settings</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.ldap.index') }}">
              <i class="fa fa-sitemap fa-4x" aria-hidden="true"></i>
              <br><br>
              LDAP
            </a>
          </h5>
          <p class="help-block">LDAP/Active Directory</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.backups.index') }}">
              <i class="fa fa-cloud-download fa-4x" aria-hidden="true"></i>
              <br><br>
              Backups
            </a>
          </h5>
          <p class="help-block">Download files &amp; Data</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <h5>
          <a href="{{ route('settings.oauth.index') }}">
            <i class="fa fa-user-secret fa-4x" aria-hidden="true"></i>
            <br><br>
            OAuth
          </a>
          </h5>
          <p class="help-block">Oauth Endpoint Settings</p>
        </div>
      </div>
    </div>

    @if (config('app.debug')=== true)
      <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
        <div class="box box-default">
          <div class="box-body text-center">
            <h5>
            <a href="{{ route('settings.phpinfo.index') }}">
                <i class="fa fa-server fa-4x" aria-hidden="true"></i>
              <br><br>
              PHP
            </a>
            </h5>
            <p class="help-block">PHP System Info</p>
          </div>
        </div>
      </div>
    @endif

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-danger">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.purge.index') }}">
              <i class="fa fa-trash fa-4x" aria-hidden="true"></i>
              <br><br>
              Purge
            </a>
          </h5>
          <p class="help-block">Purge Deleted Records</p>
        </div>
      </div>
    </div>

  </div>







<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header">
        <h2 class="box-title">{{ trans('admin/settings/general.system') }}</h2>
      </div>
      <div class="box-body">

        <div class="container row-striped">
          <div class="row">
            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.snipe_version') }}</strong>
            </div>
            <div class="col-md-4">
            {{ config('version.app_version') }}  build {{ config('version.build_version') }} ({{ config('version.hash_version') }})
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.license') }}</strong>
            </div>
          <div class="col-md-4">
              <a href="https://www.gnu.org/licenses/agpl-3.0.en.html" rel="noopener">AGPL3</a>
           </div>
          </div>

          <div class="row">

            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.php') }}</strong>
            </div>
            <div class="col-md-4">
              {{ phpversion() }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.laravel') }}</strong>
            </div>
            <div class="col-md-4">
              {{ $snipeSettings->lar_ver() }}
            </div>
          </div>
      </div> <!-- /box-body-->
    </div> <!--/box-default-->
  </div><!--/col-md-8-->
</div><!--/row-->



@stop


