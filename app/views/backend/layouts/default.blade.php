<!DOCTYPE html>

<html lang="en">
    <head>

        <!-- Basic Page Needs
        ================================================== -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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


	    <!-- global styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/compiled/layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/compiled/elements.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/compiled/icons.css') }}">

	    <!-- libraries -->
	    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-ui-1.10.2.custom.css') }}" type="text/css">
	    <link rel="stylesheet" href="{{ asset('assets/css/lib/font-awesome.min.css') }}" type="text/css">
	    <link rel="stylesheet" href="{{ asset('assets/css/lib/morris.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/lib/select2.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.datepicker.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/compiled/index.css') }}" type="text/css" media="screen" />
        <link rel="stylesheet" href="{{ asset('assets/css/compiled/user-list.css') }}" type="text/css" media="screen" />
        <link rel="stylesheet" href="{{ asset('assets/css/compiled/user-profile.css') }}" type="text/css" media="screen" />

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap-table.css') }}" type="text/css" media="screen" />

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/compiled/print.css') }}" media="print" />
        <link href="{{ asset('assets/css/bootstrap/bootstrap-overrides.css') }}" type="text/css" rel="stylesheet" />


        <!-- global header javascripts -->
        <script src="{{ asset('assets/js/jquery-latest.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

        <script>
            window.snipeit = {
                settings: {
                    "per_page": {{{ Setting::getSettings()->per_page }}}
                }
            };
        </script>



		@if (Setting::getSettings()->load_remote=='1')
        <!-- open sans font -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
		@endif

        <!--[if lt IE 9]>
          <script src="{{ asset('assets/js/html5.js') }}"></script>
        <![endif]-->

        <style>

        @section('styles')
        h3 {
            padding: 10px;
        }

        @show

		@if (Setting::getSettings()->header_color)
			.navbar-inverse {
				background-color: {{{ Setting::getSettings()->header_color }}};
				background: -webkit-linear-gradient(top,  {{{ Setting::getSettings()->header_color }}} 0%,{{{ Setting::getSettings()->header_color }}} 100%);
        background: linear-gradient(to bottom, {{{ Setting::getSettings()->header_color }}} 0%,{{{ Setting::getSettings()->header_color }}} 100%);
				border-color: {{{ Setting::getSettings()->header_color }}};

			}
		@endif

        @if (Setting::getSettings()->custom_css)
            {{ Setting::getSettings()->show_custom_css() }}
        @endif


        </style>


    </head>

    <body>

    <!-- navbar -->
    @if ((Sentry::check()) && (Sentry::getUser()->hasAccess('admin')) && (Config::get('app.debug')) && (App::environment('production')))
      <div class="row" style="margin-bottom: 0px; background-color: red; color: white; padding: 10px; font-size: 15px;">
        <div class="col-md-12">
        <i class="fa fa-warning fa-3x pull-left"></i> <strong>WARNING:</strong> This application is running in production mode with debugging enabled. This can expose sensitive data if your application is accessible to the outside world. Disable debug mode by setting the <i>debug</i> value app/config/production/app.php to <i>false</i>.
        </div>
      </div>
    @endif


    <!-- navbar -->
    <header class="navbar navbar-inverse" role="banner">
	    <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


	            @if (Setting::getSettings()->brand == '3')
                    <a class="navbar-brand" href="{{ Config::get('app.url') }}" style="padding: 5px;">
                    <img src="{{ Config::get('app.url') }}/uploads/{{{ Setting::getSettings()->logo }}}">
                    {{{ Setting::getSettings()->site_name }}}
                    </a>
                @elseif (Setting::getSettings()->brand == '2')
	            	<a class="navbar-brand" href="{{ Config::get('app.url') }}" style="padding: 5px;">
	            	<img src="{{ Config::get('app.url') }}/uploads/{{{ Setting::getSettings()->logo }}}">
	            	</a>
	            @else
	            	<a class="navbar-brand" href="{{ Config::get('app.url') }}">
	            	{{{ Setting::getSettings()->site_name }}}
	            	</a>
	            @endif
        </div>


        <ul class="nav navbar-nav navbar-right">
            @if (Sentry::check())

                 @if(Sentry::getUser()->hasAccess('admin'))
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-plus fa-fw"></i> @lang('general.create')
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                       <li {{{ (Request::is('hardware/create') ? 'class="active"' : '') }}}>
                               <a href="{{ route('create/hardware') }}">
                                   <i class="fa fa-barcode fa-fw"></i>
                                   @lang('general.asset')</a>
                           </li>
                        <li {{{ (Request::is('admin/licenses/create') ? 'class="active"' : '') }}}>
                            <a href="{{ route('create/licenses') }}">
                                <i class="fa fa-certificate fa-fw"></i>
                                @lang('general.license')</a>
                        </li>
                        <li {{{ (Request::is('admin/accessories/create') ? 'class="active"' : '') }}}>
                            <a href="{{ route('create/accessory') }}">
                                <i class="fa fa-keyboard-o fa-fw"></i>
                                @lang('general.accessory')</a>
                        </li>
                        <li {{{ (Request::is('admin/consumables/create') ? 'class="active"' : '') }}}>
                            <a href="{{ route('create/consumable') }}">
                                <i class="fa fa-tint fa-fw"></i>
                                @lang('general.consumable')</a>
                        </li>
                        <li {{{ (Request::is('admin/users/create') ? 'class="active"' : '') }}}>
                            <a href="{{ route('create/user') }}">
                            <i class="fa fa-user fa-fw"></i>
                            @lang('general.user')</a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user fa-fw"></i> {{{ Lang::get('general.welcome', array('name' => Sentry::getUser()->first_name)) }}}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li{{{ (Request::is('account/profile') ? ' class="active"' : '') }}}>
                         	<a href="{{ route('view-assets') }}">
                                <i class="fa fa-check fa-fw"></i> @lang('general.viewassets')
                        	</a>
                             <a href="{{ route('profile') }}">
                                <i class="fa fa-user fa-fw"></i> @lang('general.editprofile')
                            </a>
                             <a href="{{ route('change-password') }}">
                                <i class="fa fa-lock fa-fw"></i> @lang('general.changepassword')
                            </a>
                            <a href="{{ route('change-email') }}">
                                <i class="fa fa-envelope fa-fw"></i> @lang('general.changeemail')
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out fa-fw"></i>
                                @lang('general.logout')
                            </a>
                        </li>
                    </ul>
                </li>
                @if(Sentry::getUser()->hasAccess('admin'))
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-wrench fa-fw"></i> @lang('general.admin')
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li{{ (Request::is('admin/settings/companies*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/companies') }}">
                                <i class="fa fa-building-o fa-fw"></i> @lang('general.companies')
                            </a>
                        </li>
                        <li{{ (Request::is('hardware/models*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('hardware/models') }}">
                                <i class="fa fa-th fa-fw"></i> @lang('general.asset_models')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/settings/categories*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/categories') }}">
                                <i class="fa fa-check fa-fw"></i> @lang('general.categories')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/settings/manufacturers*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/manufacturers') }}">
                                <i class="fa fa-briefcase fa-fw"></i> @lang('general.manufacturers')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/settings/suppliers*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/suppliers') }}">
                                <i class="fa fa-credit-card fa-fw"></i> @lang('general.suppliers')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/settings/statuslabels*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/statuslabels') }}">
                                <i class="fa fa-list fa-fw"></i> @lang('general.status_labels')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/settings/depreciations*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/depreciations') }}">
                                <i class="fa fa-arrow-down fa-fw"></i> @lang('general.depreciation')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/settings/locations*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/locations') }}">
                                <i class="fa fa-globe fa-fw"></i> @lang('general.locations')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/groups*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/groups') }}">
                                <i class="fa fa-group fa-fw"></i> @lang('general.groups')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/settings/backups*') ? ' class="active"' : '') }}>
                            <a href="{{ URL::to('admin/settings/backups') }}">
                                <i class="fa fa-download fa-fw"></i> @lang('admin/settings/general.backups')
                            </a>
                        </li>
                        <li{{ (Request::is('admin/custom_fields*') ? ' class="active"' : '') }}>
                            <a href="{{ route('admin.custom_fields.index') }}">
                                <i class="fa fa-wrench fa-fw"></i> @lang('admin/custom_fields/general.custom_fields')
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('app') }}">
                                <i class="fa fa-cog fa-fw"></i> @lang('general.settings')
                            </a>
                        </li>

                    </ul>
                </li>
                @endif

            @else
                    <li {{{ (Request::is('auth/signin') ? 'class="active"' : '') }}}><a href="{{ route('signin') }}">@lang('general.sign_in')</a></li>
            @endif
            </ul>
    </header>


    <!-- end navbar -->
    @if (Sentry::check())
    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
			@if(Sentry::getUser()->hasAccess('admin'))
			<li{{ (Request::is('*/') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{Config::get('app.url')}}"><i class="fa fa-dashboard"></i><span>@lang('general.dashboard')</span></a>
            </li>
            <li{{ (Request::is('hardware*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ URL::to('hardware') }}" class="dropdown-toggle">
                    <i class="fa fa-barcode"></i>
                    <span>@lang('general.assets')</span>
                    <b class="fa fa-chevron-down"></b>
                </a>

                <ul class="submenu{{ (Request::is('hardware*') ? ' active' : '') }}">
                    <li><a href="{{ URL::to('hardware?status=Deployed') }}" {{ (Request::query('status') == 'Deployed' ? ' class="active"' : '') }} >@lang('general.deployed')</a></li>
                    <li><a href="{{ URL::to('hardware?status=RTD') }}" {{ (Request::query('status') == 'RTD' ? ' class="active"' : '') }} >@lang('general.ready_to_deploy')</a></li>
                    <li><a href="{{ URL::to('hardware?status=Pending') }}" {{ (Request::query('status') == 'Pending' ? ' class="active"' : '') }} >@lang('general.pending')</a></li>
                    <li><a href="{{ URL::to('hardware?status=Undeployable') }}" {{ (Request::query('status') == 'Undeployable' ? ' class="active"' : '') }} >@lang('general.undeployable')</a></li>
                     <li><a href="{{ URL::to('hardware?status=Archived') }}" {{ (Request::query('status') == 'Archived' ? ' class="active"' : '') }} >@lang('admin/hardware/general.archived')</a></li>
                     <li><a href="{{ URL::to('hardware?status=Requestable') }}" {{ (Request::query('status') == 'Requestable' ? ' class="active"' : '') }} >@lang('admin/hardware/general.requestable')</a></li>

                    <li><a href="{{ URL::to('hardware') }}">@lang('general.list_all')</a></li>

                    <li class="divider">&nbsp;</li>
                    <li><a href="{{ URL::to('hardware/models') }}" {{{ (Request::is('hardware/models*') ? ' class="active"' : '') }}} >@lang('general.asset_models')</a></li>
                    <li><a href="{{ URL::to('admin/settings/categories') }}" {{{ (Request::is('admin/settings/categories*') ? ' class="active"' : '') }}} >@lang('general.categories')</a></li>
                    <li><a href="{{ URL::to('hardware?status=Deleted') }}" {{{ (Request::query('Deleted') ? ' class="active"' : '') }}} >@lang('general.deleted')</a></li>
                    <li><a href="{{ URL::to('admin/asset_maintenances') }}"  >@lang('general.asset_maintenances') </a></li>
                    <li><a href="{{ URL::to('hardware/import') }}"  >@lang('general.import') </a></li>
                </ul>
            </li>
            <li{{ (Request::is('admin/accessories*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ URL::to('admin/accessories') }}">
                    <i class="fa fa-keyboard-o"></i>
                    <span>@lang('general.accessories')</span>
                </a>
            </li>
            <li{{ (Request::is('admin/consumables*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ URL::to('admin/consumables') }}">
                    <i class="fa fa-tint"></i>
                    <span>@lang('general.consumables')</span>
                </a>
            </li>


            <li{{ (Request::is('admin/licenses*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ URL::to('admin/licenses') }}"  >
                    <i class="fa fa-certificate"></i>
                     <span>@lang('general.licenses')</span>

                </a>

            </li>

            <li{{ (Request::is('admin/users*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ URL::to('admin/users') }}">
                    <i class="fa fa-users"></i>
                    <span>@lang('general.people')</span>
                </a>
            </li>
        	 @endif
        	 @if(Sentry::getUser()->hasAccess('reports'))
            <li{{ (Request::is('reports*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ URL::to('reports') }}"  class="dropdown-toggle">
                    <i class="fa fa-bar-chart"></i>
                    <span>@lang('general.reports')
                    <b class="fa fa-chevron-down"></b></span>

                </a>

                <ul class="submenu{{ (Request::is('reports*') ? ' active' : '') }}">
	                 <li><a href="{{ URL::to('reports/activity') }}" {{ (Request::is('reports/activity') ? ' class="active"' : '') }} >@lang('general.activity_report')</a></li>

                    <li><a href="{{ URL::to('reports/depreciation') }}" {{{ (Request::is('reports/depreciation') ? ' class="active"' : '') }}} >@lang('general.depreciation_report')</a></li>
                    <li><a href="{{ URL::to('reports/licenses') }}" {{{ (Request::is('reports/licenses') ? ' class="active"' : '') }}} >@lang('general.license_report')</a></li>
                    <li><a href="{{ URL::to('reports/asset_maintenances') }}" {{{ (Request::is('reports/asset_maintenances') ? ' class="active"' : '') }}} >@lang('general.asset_maintenance_report')</a></li>
                    <li><a href="{{ URL::to('reports/assets') }}" {{{ (Request::is('reports/assets') ? ' class="active"' : '') }}} >@lang('general.asset_report')</a></li>
                    <li><a href="{{ URL::to('reports/unaccepted_assets') }}" {{{ (Request::is('reports/unaccepted_assets') ? ' class="active"' : '') }}} >@lang('general.unaccepted_asset_report')</a></li>
                    <li><a href="{{ URL::to('reports/accessories') }}" {{{ (Request::is('reports/accessories') ? ' class="active"' : '') }}} >@lang('general.accessory_report')</a></li>
                    <li><a href="{{ URL::to('reports/custom') }}" {{{ (Request::is('reports/custom') ? ' class="active"' : '') }}} >@lang('general.custom_report')</a></li>
                </ul>
            </li>
             @endif
             @if(!Sentry::getUser()->hasAccess('admin'))
              <li{{ (Request::is('account/requestable-assets') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ route('requestable-assets') }}">
                    <i class="fa fa-laptop"></i>
                    <span>@lang('admin/hardware/general.requestable')</span>
                </a>
            </li>
            @endif



        </ul>
    </div>
    <!-- end sidebar -->

    @endif


<!-- main container -->
    <div class="content">

        @if ((Sentry::check()) && (Sentry::getUser()->hasAccess('admin')))
        @if (Request::is('/'))

        <!-- upper main stats -->
        <div id="main-stats">
            <div class="row stats-row">
                <div class="col-md-3 col-sm-3 stat">
                    <div class="data">
                            <a href="{{ URL::to('hardware') }}">
                                <span class="number">{{ number_format(Asset::assetcount()) }}</span>
                                   <span style="color:black">@lang('general.total_assets')</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 stat">
                        <div class="data">
                            <a href="{{ URL::to('hardware?status=RTD') }}">
                                <span class="number">{{ number_format(Asset::availassetcount()) }}</span>
                                <span style="color:black">@lang('general.assets_available')</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 stat">
                        <div class="data">
                            <a href="{{ URL::to('admin/licenses') }}">
                                <span class="number">{{ number_format(License::assetcount()) }}</span>
                                <span style="color:black">@lang('general.total_licenses')</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 stat last">
                        <div class="data">
                            <a href="{{ URL::to('admin/licenses') }}">
                                <span class="number">{{ number_format(License::availassetcount()) }}</span>
                                <span style="color:black">@lang('general.licenses_available')</span>
                            </a>
                        </div>
                    </div>
                </div>


        <!-- end upper main stats -->
        @endif
        @endif


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

        <div id="footer" class="col-md-offset-2 col-md-9 col-sm-12 col-xs-12 text-center">
		                <div class="muted credit hidden-xs">
	                  			<a target="_blank" href="http://snipeitapp.com">Snipe IT</a> is a free open source
					  		project by
					  			<a target="_blank" href="http://twitter.com/snipeyhead">@snipeyhead</a>.
						  		<a target="_blank" href="https://github.com/snipe/snipe-it">Fork it</a> |
						  		<a target="_blank" href="http://docs.snipeitapp.com/">Documentation</a> |
						  		<a target="_blank" href="http://docs.snipeitapp.com/translations.html">Translate It! </a> |
						  		<a target="_blank" href="https://github.com/snipe/snipe-it/issues?state=open">Report a Bug</a>
						  		 &nbsp; &nbsp; ({{{  Config::get('version.app_version') }}})
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button><a class="btn btn-danger btn-sm" id="dataConfirmOK">@lang('general.yes')</a>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery.knob.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.uniform.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/snipeit.js') }}"></script>

    <script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
    </script>


    @section('moar_scripts')
	@show

    </body>
</html>
