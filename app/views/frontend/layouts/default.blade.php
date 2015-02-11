<!DOCTYPE html>

<html lang="en">
    <head>

        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8" />
        <title>
            @section('title')
             {{{ Setting::getSettings()->site_name }}}
            @show
        </title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">



        <!-- bootstrap -->
        <link href="{{ asset('assets/css/bootstrap/bootstrap.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap/bootstrap-overrides.css') }}" type="text/css" rel="stylesheet" />



        <!-- libraries -->
        <link href="{{ asset('assets/css/lib/uniform.default.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/lib/select2.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('assets/css/lib/bootstrap.datepicker.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('assets/css/lib/font-awesome.css') }}" type="text/css" rel="stylesheet" />

        <!-- global styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/compiled/layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/compiled/elements.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/compiled/icons.css') }}">


        <!-- this page specific styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/compiled/index.css') }}" type="text/css" media="screen" />
        <link rel="stylesheet" href="{{ asset('assets/css/compiled/user-list.css') }}" type="text/css" media="screen" />
        <link rel="stylesheet" href="{{ asset('assets/css/compiled/user-profile.css') }}" type="text/css" media="screen" />
        <link rel="stylesheet" href="{{ asset('assets/css/compiled/form-showcase.css') }}" type="text/css" media="screen" />
        <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery.dataTables.css') }}" type="text/css" media="screen" />
        <link rel="stylesheet" href="//cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css" type="text/css" media="screen" />



        <!-- global header javascripts -->
        <script src="//code.jquery.com/jquery-latest.js"></script>
        <script src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/responsive/1.0.2/js/dataTables.responsive.js"></script>

        <script>
            window.snipeit = {
                settings: {
                    "per_page": {{{ Setting::getSettings()->per_page }}}
                }
            };
        </script>



        <!-- open sans font -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <style>

        @section('styles')
        h3 {
            padding: 10px;
        }

        @show

        </style>


    </head>

    <body>

    <!-- navbar -->


    <!-- navbar -->
    <header class="navbar navbar-inverse" role="banner">

    <div class="navbar navbar-inverse">
        <div class="navbar-inner navbar-inverse">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{{ Setting::getSettings()->site_name }}}</a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            @if (Sentry::check())

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{{ Lang::get('general.welcome', array('name' => Sentry::getUser()->first_name)) }}}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li{{{ (Request::is('account/profile') ? ' class="active"' : '') }}}>
                         	<a href="{{ route('view-assets') }}">
                                <i class="icon-check"></i> @lang('general.viewassets')
                        	</a>
                             <a href="{{ route('profile') }}">
                                <i class="icon-user"></i> @lang('general.editprofile')
                            </a>
                             <a href="{{ route('change-password') }}">
                                <i class="icon-lock"></i> @lang('general.changepassword')
                            </a>
                            <a href="{{ route('change-email') }}">
                                <i class="icon-envelope"></i> @lang('general.changeemail')
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="icon-off"></i>
                                @lang('general.logout')
                            </a>
                        </li>
                    </ul>
                </li>


            @else
                    <li {{{ (Request::is('auth/signin') ? 'class="active"' : '') }}}><a href="{{ route('signin') }}">@lang('general.sign_in')</a></li>
            @endif
            </ul>
        </div>
    </div>
    </header>
    <!-- end navbar -->

    @if (Sentry::check())
		<!-- sidebar -->
		<div id="sidebar-nav">
			<ul id="dashboard-menu">


			 <li><a href="{{ route('requestable-assets') }}" {{{ (Request::is('view-requestable*') ? ' class="active"' : '') }}} >@lang('admin/hardware/general.requestable')</a></li>

			</ul>
		</div>
		<!-- end sidebar -->

    @endif


<!-- main container -->
    <div class="content">
                <div id="pad-wrapper">

                        <!-- Notifications -->
                        @include('frontend/notifications')

                        <!-- Content -->
                        @yield('content')

                </div>
            </div>
        </div>
    </div>

    <footer>
    	<div class="col-md-2">
        </div>
        <div id="footer">
        <div class="col-md-9">
              <div class="container">

                  <div class="muted credit" style="position:absolute;margin-top:1px;left:80px;margin-right:100px;">
	                  	<a target="_blank" href="http://snipeitapp.com">Snipe IT</a> is a free open source
					  	project by <a target="_blank" href="http://twitter.com/snipeyhead">@snipeyhead</a>.</div>
					  	<div class="muted credit" style="position:absolute;margin-top:1px;right:80px;margin-left:100px;">
						  		<a target="_blank" href="https://github.com/snipe/snipe-it">Fork it</a> |
						  		<a target="_blank" href="http://docs.snipeitapp.com/">Documentation</a> |
						  		<a href="https://crowdin.com/project/snipe-it">Help Translate It! </a> |
						  		<a target="_blank" href="https://github.com/snipe/snipe-it/issues?state=open">Report a Bug</a>
						  		 &nbsp; &nbsp; (v1.2.4)</p>
                  	</div>
              </div>
        </div>
        </div>
    </footer>

    <!-- end main container -->

    <div class="modal fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><a class="btn btn-danger" id="dataConfirmOK">@lang('general.yes')</a>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.knob.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.uniform.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/snipeit.js') }}"></script>



    </body>
</html>
