@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.settings') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div id="pad-wrapper" class="user-profile">
                <!-- header -->

                <div class="pull-right">
                     <a href="{{ route('edit/settings') }}" class="btn btn-warning">@lang('actions.update')</a>
                </div>


                <h3 class="name">@lang('base.settings')</h3>


                <div class="row-fluid profile">
                    <div class="col-md-9 bio">
                     
                    <!-- display current application settings table -->
                    
                        <div class="">   
                            <br>
                            <table class="table table-hover">
                            <thead>
                               <!-- <tr>
                                    <th class="col-md-3">@lang('base.setting_shortname')</th>
                                    <th class="col-md-3"><span class="line"></span>@lang('general.value')</th>
                                </tr> -->
                            </thead>
                            <tbody>
                                
                                <!-- Loop through for each - but there should ONLY be one settings row in the table -->
                                @foreach ($settings as $setting)
                                
                                <!-- site name -->
                                <tr>
                                    <td>@lang('admin/settings/form.sitename')</td>
                                    <td>{{{ $setting->site_name }}} </td>
                                </tr>
                                
                                <!-- Show asset names -->
                                <tr>
                                    <td>@lang('admin/settings/form.display_asset_name')</td>


                                    @if ($setting->display_asset_name === 1)
                                        <td>Yes</td>
                                    @else
                                        <td>No</td>
                                    @endif
                                </tr>

                                <!-- Rows per page -->
                                <tr>
                                    <td>@lang('admin/settings/form.rowsperpage')</td>
                                    <td>{{{ $setting->per_page }}}  </td>
                                </tr>
                                
                                <!-- allow multiple logons -->
                                <tr>
                                    <td>@lang('admin/settings/form.multiplelogons')</td>
                                    @if ($setting->multiplelogons === 1)
                                        <td>Yes</td>
                                    @else
                                        <td>No</td>
                                    @endif
                                </tr>
                                
                                <!-- Display QR codes -->
                                <tr>
                                    <td>@lang('admin/settings/form.displayqrcodes')</td>
                                        @if ($setting->qr_code === 1)
                                            <td>Yes</td>
                                        @else
                                            <td>No</td>
                                        @endif
                                </tr>
                                
                                <!-- QR code text -->
                                <tr>
                                    <td>@lang('admin/settings/form.qrcodetext')</td>
                                    <td>{{{ $setting->qr_text }}}</td>
                                </tr>
                                
                                <!-- show detailed system info -->
                                <tr>
                                    <td>@lang('admin/settings/form.showsysinfo')</td>
                                    @if ($setting->showsysinfo === 1)
                                        <td>Yes</td>
                                    @else
                                        <td>No</td>
                                    @endif
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
                            <!-- display detailed system info if showsysinfo set true -->
                            @if ($setting->showsysinfo === 1)
                            
                            <p>PHP Information:</p>
                           
                            <p>
                            <?php
                            ob_start();
                            phpinfo(5);

                            preg_match ('%<style type="text/css">(.*?)</style>.*?<body>(.*?)</body>%s', ob_get_clean(), $matches);

                            # $matches [1]; # Style information
                            # $matches [2]; # Body information

                            echo "<div class='phpinfodisplay'><style type='text/css'>\n",
                                join( "\n",
                                    array_map(
                                        create_function('$i','return ".phpinfodisplay " . preg_replace( "/,/", ",.phpinfodisplay ", $i );'),
                                        preg_split( '/\n/', trim(preg_replace( "/\nbody/", "\n", $matches[1])) )
                                        )
                                    ),
                                "</style>\n",
                                $matches[2],
                                "\n</div>\n";
                            ?>
                            </p>
                            
                            @endif
                            <! -- end show system information boolean -->
                        </div>
               
                    </div>

                </div>

                
        <!-- side address column -->
        <div class="col-md-3 address pull-right">
            <br>
            <h4>@lang('base.setting_about')</h4>
            <br />
            <p>@lang('admin/settings/message.about') </p>
        </div>
        
@stop
