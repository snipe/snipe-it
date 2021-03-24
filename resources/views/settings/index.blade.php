@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.admin') }}
@parent
@stop

{{-- Page content --}}
@section('content')



  <style>
    #searchinput {
      width: 200px;
    }
    #searchclear {
      position: absolute;
      right: 5px;
      top: 0;
      bottom: 0;
      height: 14px;
      margin: auto;
      font-size: 14px;
      cursor: pointer;
      color: #ccc;
    }
  </style>

  <div class="row" id="setting-list">

    <!-- search filter box -->
    <div class="col-md-3 col-md-offset-9 form-group">
      <form onsubmit="return false;">
        <div class="btn-group">
          <input id="searchinput" name="search" type="search" class="search form-control" placeholder="Filter by setting keyword">
          <span id="searchclear" class="fa fa-times" aria-hidden="true"></span>
          <button type="submit" disabled style="display: none" aria-hidden="true"></button>
        </div>
      </form>
    </div>
    <!--/ search filter box -->


    <!-- search filter list -->
    <div class="list">

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
              <a href="{{ route('settings.branding.index') }}">
                <i class="fa fa-copyright fa-4x" aria-hidden="true"></i>
                <br><br>
                <span class="name">Branding</span>
                <span class="keywords" aria-hidden="true" style="display:none">footer, logo, print, theme, skin, header, colors, color, css</span>
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
                  <span class="name"> General Settings</span>
                  <span class="keywords" aria-hidden="true" style="display:none">company support, signature, acceptance, email format, username format, images, per page, thumbnail, eula,  tos, dashboard, privacy</span>
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
                  <span class="name">Security</span>
                  <span class="keywords" aria-hidden="true" style="display:none">password, passwords, requirements, two factor, two-factor, common passwords, remote login, logout, authentication</span>
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
                  <span class="name">Groups</span>
                  <span class="keywords" aria-hidden="true" style="display:none">permissions, permission groups, authorization</span>
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
                  <span class="name">Localization</span>
                  <span class="keywords" aria-hidden="true" style="display:none">localization, currency, local, locale, time zone, timezone, international, internatinalization, language, languages, translation</span>
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
                  <span class="name">Notifications</span>

                </a>
              </h5>
              <p class="help-block">Email alerts, audit settings</p>
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
                  <span class="name">Slack</span>
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
                  <span class="name">Asset Tags</span>
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
                  <span class="name">Barcodes</span>
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
                  <span class="name">Labels</span>
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
                  <span class="name">LDAP</span>
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
              <a href="{{ route('settings.saml.index') }}">
                <i class="fa fa-sign-in fa-4x" aria-hidden="true"></i>
                <br><br>
                <span class="name">SAML</span>
              </a>
            </h5>
            <p class="help-block">SAML settings</p>
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
                  <span class="name">Backups</span>
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
              <a href="{{ route('settings.logins.index') }}">
                <i class="fa fa-crosshairs fa-4x" aria-hidden="true"></i>
                <br><br>
                <span class="name">Login Attempts</span>
              </a>
            </h5>
            <p class="help-block">List of attempted logins </p>
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
                <span class="name">OAuth</span>
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
                    <span class="name">PHP</span>
                    <span class="keywords" aria-hidden="true" style="display:none">phpinfo, system, info</span>
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
              <span class="name">Purge</span>
              <span class="keywords" aria-hidden="true" style="display:none">permanently delete</span>
            </a>
          </h5>
          <p class="help-block">Purge Deleted Records</p>
        </div>
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
        <div class="container row-striped col-md-11">

          <!-- row -->
          <div class="row">
            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.snipe_version') }}</strong>
            </div>
            <div class="col-md-4">
            {{ config('version.app_version') }}  build {{ config('version.build_version') }} ({{ config('version.hash_version') }})
            </div>

            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.license') }}</strong>
            </div>
          <div class="col-md-4">
              <a href="https://www.gnu.org/licenses/agpl-3.0.en.html" rel="noopener">AGPL3</a>
           </div>
          </div>
          <!-- / row -->

          <!-- row -->
          <div class="row">
            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.php') }}</strong>
            </div>
            <div class="col-md-4">
              {{ phpversion() }}
            </div>

            <div class="col-md-2">
              <strong>{{ trans('admin/settings/general.laravel') }}</strong>
            </div>
            <div class="col-md-4">
              {{ $snipeSettings->lar_ver() }}
            </div>

          </div>
          <!--/ row -->
        </div>
      </div> <!-- /box-body-->
    </div> <!--/box-default-->
  </div><!--/col-md-8-->
</div><!--/row-->

  @section('moar_scripts')
<script nonce="{{ csrf_token() }}">



  var options = {
    valueNames: [ 'name', 'keywords', 'summary', 'help-block']
  };

  var userList = new List('setting-list', options);

  $("#searchclear").click(function(){
    $("#searchinput").val('');
    userList.search();
  });



</script>
  @endsection

@stop


