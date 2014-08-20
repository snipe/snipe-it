@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Default Settings ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div id="pad-wrapper" class="user-profile">
                <!-- header -->

          


                <h3 class="name">@lang('admin/settings/general.title')</h3>


                <div class="row-fluid profile">
                    <!-- information column -->
                    <div class="col-md-9 bio">
                     
                    <!-- display current application settings table -->
                    <p><h4 class="name">@lang('admin/defaultsettings/general.default_settings')</h4></p>
                    
                        <div class="profile-box">   

                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-3">@lang('admin/settings/general.setting')</th>
                                    <th class="col-md-3"><span class="line"></span>@lang('admin/settings/general.value')</th>
                                    
                                    <th class="col-md-2 actions">@lang('table.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
               
                                
                                @foreach ($default_settings as $setting)
                                <tr>
                                    <td>@lang('admin/defaultsettings/table.values.' . $setting->name)</td>
                                    <td>{{{ $setting->value }}}</td>                                   
                                    <td>
                                        <a href="{{ route('edit/defaultsettings', $setting->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                   
                <!-- show current system information -->
                <br>
                        <p><h4 class="name">@lang('admin/settings/general.systeminfo')</h4></p>

                        <div class="profile-box">
                            <p>Application Version: &nbsp; &nbsp; {{ appVersion() }} </p>
                            <p>
                            <?php 
                            $laravel = app();
                            $version = $laravel::VERSION;
                            ?>
                            Laravel Version: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {{{ $version }}}
                            </p>                            
                        </div>
               
                    </div>

                </div>

                
                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
                        <br /><br />

                        <p>@lang('admin/settings/general.settings_info')</p>

                    </div>
@stop