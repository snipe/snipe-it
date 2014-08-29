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

                            
               
                                
                                @foreach ($countries as $country)
                                    <li>{{{ $country->name }}}</li>  
                                @endforeach
                           
                        </div>
                   
                <!-- show current system information -->
                <br>
                        <p><h4 class="name">@lang('admin/settings/general.systeminfo')</h4></p>

                        <div class="profile-box">
                                                 
                        </div>
               
                    </div>

                </div>

                
                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
                        <br /><br />

                        <p>@lang('admin/settings/general.settings_info')</p>

                    </div>
@stop