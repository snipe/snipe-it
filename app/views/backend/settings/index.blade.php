@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('admin/settings/general.settings') ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->

                <div class="pull-right">
                     <a href="{{ route('edit/settings') }}" class="btn btn-warning btn-sm"> @lang('button.edit') Settings</a>
                </div>

                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <h3 class="name">@lang('admin/settings/general.settings')</h3>
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <table class="table table-hover">
                                <tbody>
                                    @foreach ($settings as $setting)
                                    <tr>
                                        <td>@lang('admin/settings/general.site_name')</td>
                                        <td>{{{ $setting->site_name }}} </td>
                                    </tr>
                                     <tr>
                                        <td>@lang('admin/settings/general.alert_email')</td>

                                        @if ($setting->alert_email)
                                            <td>{{{ $setting->alert_email }}}</td>
                                        @else
                                            <td>--</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>@lang('admin/settings/general.alerts_enabled')</td>

                                        @if ($setting->alerts_enabled == 1)
                                            <td>@lang('general.yes')</td>
                                        @else
                                            <td>@lang('general.no')</td>
                                        @endif
                                    </tr>

                                     <tr>
                                        <td>@lang('admin/settings/general.header_color')</td>

                                        @if ($setting->header_color)
                                            <td>{{{ $setting->header_color }}}</td>
                                        @else
                                            <td>default</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>@lang('admin/settings/general.display_asset_name')</td>

                                        @if ($setting->display_asset_name == 1)
                                            <td>@lang('general.yes')</td>
                                        @else
                                            <td>@lang('general.no')</td>
                                        @endif
                                    </tr>

                                     <tr>
                                        <td>@lang('admin/settings/general.display_eol')</td>

                                        @if ($setting->display_eol == 1)
                                            <td>@lang('general.yes')</td>
                                        @else
                                            <td>@lang('general.no')</td>
                                        @endif
                                    </tr>


                                    <tr>
                                        <td>@lang('admin/settings/general.display_checkout_date')</td>


                                        @if ($setting->display_checkout_date == 1)
                                            <td>@lang('general.yes')</td>
                                        @else
                                            <td>@lang('general.no')</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td>@lang('admin/settings/general.auto_increment_assets')</td>

                                        @if ($setting->auto_increment_assets == 1)
                                            <td>@lang('general.yes')</td>
                                        @else
                                            <td>@lang('general.no')</td>
                                        @endif
                                    </tr>
                                    
                                    <tr>
                                        <td>@lang('admin/settings/general.load_remote')</td>

                                        @if ($setting->load_remote == 1)
                                            <td>@lang('general.yes')</td>
                                        @else
                                            <td>@lang('general.no')</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td>@lang('admin/settings/general.auto_increment_prefix')</td>
                                        <td>{{{ $setting->auto_increment_prefix }}}</td>
                                    </tr>


                                    <tr>
                                        <td>@lang('admin/settings/general.per_page')</td>
                                        <td>{{{ $setting->per_page }}}  </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('admin/settings/general.display_qr')</td>
                                            @if ($setting->qr_code == 1)
                                                <td>@lang('general.yes')
	                                                {{{ $setting->qr_text }}}
	                                                
                                                </td>
                                            @else
                                                <td>@lang('general.no')</td>
                                            @endif
                                    </tr>                                    
                                    <tr>
                                        <td>@lang('admin/settings/general.default_eula_text')</td>

                                        @if ($setting->default_eula_text!='')
                                            <td>@lang('general.yes')</td>
                                        @else
                                            <td>@lang('general.no')</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- side address column -->
                    <div class="col-md-3 address pull-right">
                        <br /><br />

                        <p>These settings let you customize certain aspects of your installation. </p>

                    </div>

                    <div class="col-md-9 bio">
                        <h3 class="name">@lang('admin/settings/general.system')</h3>
                        <div class="profile-box">
                            <br>
                            <table class="table table-hover">
                                <tbody>
	                                <tr>
                                        <td>@lang('admin/settings/general.snipe_version')</td>
                                        <td>
                                            {{{  Config::get('version.latest') }}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('admin/settings/general.php')</td>
                                        <td> {{{ phpversion() }}}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('admin/settings/general.laravel')</td>
                                        <td>
                                            {{{ $setting->lar_ver() }}}
                                        </td>
                                    </tr>
                                    
                                    
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
@stop