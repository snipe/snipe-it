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
                     <a href="{{ route('edit/settings') }}" class="btn btn-warning"> @lang('button.edit') Settings</a>
                </div>


                <h3 class="name">@lang('admin/settings/general.settings')</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-3">@lang('admin/settings/general.setting')</th>
                                    <th class="col-md-3"><span class="line"></span>@lang('admin/settings/general.value')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settings as $setting)
                                <tr>
                                    <td>@lang('admin/settings/general.site_name')</td>
                                    <td>{{{ $setting->site_name }}} </td>
                                </tr>
                                <tr>
                                    <td>@lang('admin/settings/general.display_asset_name')</td>


                                    @if ($setting->display_asset_name == 1)
                                        <td>Yes</td>
                                    @else
                                        <td>No</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>@lang('admin/settings/general.display_checkout_date')</td>


                                    @if ($setting->display_checkout_date == 1)
                                        <td>Yes</td>
                                    @else
                                        <td>No</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>@lang('admin/settings/general.per_page')</td>
                                    <td>{{{ $setting->per_page }}}  </td>
                                </tr>
                                <tr>
                                    <td>@lang('admin/settings/general.display_qr')</td>
                                        @if ($setting->qr_code == 1)
                                            <td>Yes</td>
                                        @else
                                            <td>No</td>
                                        @endif
                                </tr>
                                <tr>
                                    <td>@lang('admin/settings/general.qr_text')</td>
                                    <td>{{{ $setting->qr_text }}}</td>
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
@stop
