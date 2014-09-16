@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.defaultsettings') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div id="pad-wrapper" class="user-profile">
                <!-- header -->

          


                <h3 class="name">@lang('base.defaultsettings')</h3>


                <div class="row-fluid profile">
                    <!-- information column -->
                    <div class="col-md-9 bio">
                    
                        <div class="">   
                            <br>
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-3">@lang('general.setting')</th>
                                    <th class="col-md-3"><span class="line"></span>@lang('general.value')</th>
                                    
                                    <th class="col-md-2 actions">@lang('actions.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
               
                                
                                @foreach ($default_settings as $setting)
                                <tr>
                                    <td>@lang('admin/defaultsettings/form.values.' . $setting->name)</td>
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
                        <p><h4 class="name">@lang('general.systeminfo')</h4></p>

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
    <br />
    <h6>@lang('base.defaultsetting_about')</h6>
    <p>@lang('admin/defaultsettings/message.about') </p>

                    </div>
@stop