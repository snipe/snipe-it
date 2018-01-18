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
          品牌
          <p class="help-block">商标, 名称</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.general.index') }}" class="btn btn-lg btn-white"><i class="fa fa-wrench fa-3x"></i></a>
          <br>
         通用设置
          <p class="help-block">默认EULA</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.security.index') }}" class="btn btn-lg btn-white"><i class="fa fa-lock fa-3x"></i></a>
          <br>
          安全
          <p class="help-block">双因素，密码限制</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('groups.index') }}" class="btn btn-lg btn-white"><i class="fa fa-group fa-3x"></i></a>
          <br>
          租
          <p class="help-block">帐户权限组</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.localization.index') }}" class="btn btn-lg btn-white"><i class="fa fa-globe fa-3x"></i></a>
          <br>
          本地化
          <p class="help-block">语言, 日期</p>

        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.alerts.index') }}" class="btn btn-lg btn-white"><i class="fa fa-bell fa-3x"></i></a>
          <br>
         提醒
          <p class="help-block">邮件警告</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.slack.index') }}" class="btn btn-lg btn-white"><i class="fa fa-slack fa-3x"></i></a>
          <br>
          弹性
          <p class="help-block">弹性设置</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.asset_tags.index') }}" class="btn btn-lg btn-white"><i class="fa fa-list-ol fa-3x"></i></a>
          <br>
          资产标签
          <p class="help-block">递增和前缀</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.barcodes.index') }}" class="btn btn-lg btn-white"><i class="fa fa-barcode fa-3x"></i></a>
          <br>
          二维码
          <p class="help-block">二维码 &amp; QR 设置</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.labels.index') }}" class="btn btn-lg btn-white"><i class="fa fa-tags fa-3x"></i></a>
          <br>
          标签
          <p class="help-block">标签大小 &amp; 设置</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.ldap.index') }}" class="btn btn-lg btn-white"><i class="fa fa-sitemap fa-3x"></i></a>
          <br>
          LDAP
          <p class="help-block">LDAP/活动目录</p>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.backups.index') }}" class="btn btn-lg btn-white"><i class="fa fa-cloud-download fa-3x"></i></a>
          <br>
          备用
          <p class="help-block">下载文件 &amp; 数据</p>
        </div>
      </div>
    </div>


    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-default">
        <div class="box-body text-center">
          <a href="{{ route('settings.oauth.index') }}" class="btn btn-lg btn-white"><i class="fa fa-user-secret fa-3x"></i></a>
          <br>
          OAuth
          <p class="help-block">Oauth 设置</p>
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
            <p class="help-block">PHP 系统信息</p>
          </div>
        </div>
      </div>
    @endif

    <div class="col-md-4 col-lg-3 col-sm-6 col-xl-1">
      <div class="box box-danger">
        <div class="box-body text-center">
          <a href="{{ route('settings.purge.index') }}" class="btn btn-lg btn-white text-danger"><i class="fa fa-trash fa-3x"></i></a>
          <br>
          清空
          <p class="help-block">清除已删除的记录</p>
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


