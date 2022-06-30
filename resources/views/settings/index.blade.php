@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.admin') }}
@parent
@stop

@section('header_right')



  <!-- search filter box -->
  <div class="pull-right">


    <form onsubmit="return false;">
      <div class="btn-group">
        <input id="searchinput" name="search" type="search" class="search form-control" placeholder="{{ trans('admin/settings/general.filter_by_keyword') }}">
        <span id="searchclear" class="fas fa-times" aria-hidden="true"></span>
        <button type="submit" disabled style="display: none" aria-hidden="true"></button>
      </div>
      <a href="{{ route('settings.index') }}" class="btn btn-primary pull-right" style="margin-left: 10px;">{{ trans('general.back') }}</a>

    </form>




  </div>
  <!--/ search filter box -->
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


    <!-- search filter list -->
    <div class="list">

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
              <a href="{{ route('settings.branding.index') }}" class="settings_button">
                <i class="fas fa-copyright fa-4x" aria-hidden="true"></i>
                <br><br>
                <span class="name">{{ trans('admin/settings/general.brand') }}</span>
                <span class="keywords" aria-hidden="true" style="display:none">{{ trans('admin/settings/general.brand_keywords') }}</span>
              </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.brand_help') }}</p>
            </div>
          </div>
        </div>


        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.general.index') }}" class="settings_button">
                  <i class="fas fa-wrench fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name"> {{ trans('admin/settings/general.general_settings') }}</span>
                  <span class="keywords" aria-hidden="true" style="display:none">{{ trans('admin/settings/general.general_settings_keywords') }}</span>
                </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.general_settings_help') }}</p>
            </div>
          </div>
        </div>


        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.security.index') }}" class="settings_button">
                  <i class="fas fa-lock fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.security') }}</span>
                  <span class="keywords" aria-hidden="true" style="display:none">{{ trans('admin/settings/general.security_keywords') }}</span>
                </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.security_help') }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('groups.index') }}" class="settings_button">
                  <i class="fas fa-user-friends fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('general.groups') }}</span>
                  <span class="keywords" aria-hidden="true" style="display:none"> {{ trans('admin/settings/general.groups_keywords') }}</span>
                  </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.groups_help') }}</p>
            </div>
          </div>
        </div>


        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.localization.index') }}" class="settings_button">
                  <i class="fas fa-globe-americas fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.localization') }}</span>
                  <span class="keywords" aria-hidden="true" style="display:none"> {{ trans('admin/settings/general.localization_keywords') }}</span>
                </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.localization_help') }}</p>

            </div>
          </div>
        </div>


        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.alerts.index') }}" class="settings_button">
                  <i class="fas fa-bell fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.notifications') }}</span>

                </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.notifications_help') }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.slack.index') }}" class="settings_button">
                  <i class="fab fa-slack fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.slack') }}</span>
                </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.slack_help') }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.asset_tags.index') }}" class="settings_button">
                  <i class="fas fa-list-ol fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('general.asset_tags') }}</span>
                </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.asset_tags_help') }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.barcodes.index') }}" class="settings_button">
                  <i class="fas fa-barcode fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.barcodes') }}</span>
                </a>
              </h5>
              <p class="help-block">{!! trans('admin/settings/general.barcodes_help_overview') !!}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.labels.index') }}" class="settings_button">
                  <i class="fas fa-tags fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.labels') }}</span>
                </a>
              </h5>
              <p class="help-block">{!! trans('admin/settings/general.labels_help') !!}</p>
            </div>
          </div>
        </div>


        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.ldap.index') }}" class="settings_button">
                  <i class="fas fa-sitemap fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.ldap') }}</span>
                </a>
              </h5>
              <p class="help-block">{{ trans('admin/settings/general.ldap_help') }}</p>
            </div>
          </div>
        </div>

      <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
        <div class="box box-default">
          <div class="box-body text-center">
            <h5>
              <a href="{{ route('settings.saml.index') }}" class="settings_button">
                <i class="fas fa-sign-in-alt fa-4x" aria-hidden="true"></i>
                <br><br>
                <span class="name">{{ trans('admin/settings/general.saml') }}</span>
              </a>
            </h5>
            <p class="help-block">{{ trans('admin/settings/general.saml_help') }}</p>
          </div>
        </div>
      </div>

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
                <a href="{{ route('settings.backups.index') }}" class="settings_button">
                  <i class="fas fa-file-archive fa-4x" aria-hidden="true"></i>
                  <br><br>
                  <span class="name">{{ trans('admin/settings/general.backups') }}</span>
                </a>
              </h5>
              <p class="help-block">{!! trans('admin/settings/general.backups_help') !!}</p>
            </div>
          </div>
        </div>


      <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
        <div class="box box-default">
          <div class="box-body text-center">
            <h5>
              <a href="{{ route('settings.logins.index') }}" class="settings_button">
                <i class="fas fa-crosshairs fa-4x" aria-hidden="true"></i>
                <br><br>
                <span class="name">{{ trans('admin/settings/general.login') }}</span>
              </a>
            </h5>
            <p class="help-block">{{ trans('admin/settings/general.login_help') }} </p>
          </div>
        </div>
      </div>

        <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
          <div class="box box-default">
            <div class="box-body text-center">
              <h5>
              <a href="{{ route('settings.oauth.index') }}" class="settings_button">
                <i class="fas fa-user-secret fa-4x" aria-hidden="true"></i>
                <br><br>
                <span class="name">{{  trans('admin/settings/general.oauth') }}</span>
              </a>
              </h5>
              <p class="help-block">{{  trans('admin/settings/general.oauth_help') }}</p>
            </div>
          </div>
        </div>

        @if (config('app.debug')=== true)
          <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
            <div class="box box-default">
              <div class="box-body text-center">
                <h5>
                  <a href="{{ route('settings.phpinfo.index') }}" class="settings_button">
                    <i class="fab fa-php fa-4x" aria-hidden="true"></i>
                    <br><br>
                    <span class="name">{{ trans('admin/settings/general.php_overview') }}</span>
                    <span class="keywords" aria-hidden="true" style="display:none">{{ trans('admin/settings/general.php_overview_keywords') }}</span>
                  </a>
                </h5>
                <p class="help-block">{{ trans('admin/settings/general.php_overview_help') }}</p>
              </div>
            </div>
          </div>
        @endif


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-danger">
        <div class="box-body text-center">
          <h5>
            <a href="{{ route('settings.purge.index') }}" class="link-danger">
              <i class="fas fa-trash fa-4x" aria-hidden="true"></i>
              <br><br>
              <span class="name">{{ trans('admin/settings/general.purge') }}</span>
              <span class="keywords" aria-hidden="true" style="display:none">{{ trans('admin/settings/general.purge_keywords') }}</span>
            </a>
          </h5>
          <p class="help-block">{{ trans('admin/settings/general.purge_help') }}</p>
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

  var settingList = new List('setting-list', options);

  $("#searchclear").click(function(){
    $("#searchinput").val('');
    settingList.search();
  });



</script>
  @endsection

@stop


