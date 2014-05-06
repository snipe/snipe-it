<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			 {{ Setting::getSettings()->site_name }}
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

        <!-- global header javascripts -->
        <script src="//code.jquery.com/jquery-latest.js"></script>
        <script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>

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
            <a class="navbar-brand" href="/">{{ Setting::getSettings()->site_name }}</a>
        </div>

        <ul class="nav navbar-nav pull-right hidden-xs">
            @if (Sentry::check())

				 @if(Sentry::getUser()->hasAccess('admin'))
				 <li class="dropdown">
                    <a href="#" class="dropdown-toggle hidden-xs hidden-sm" data-toggle="dropdown">
                        <i class="icon-plus"></i> @lang('general.create')
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                       <li {{ (Request::is('hardware/create') ? 'class="active"' : '') }}>
                       		<a href="{{ route('create/hardware') }}">
                       			<i class="icon-plus"></i>
                       			@lang('general.asset')</a>
                       	</li>
						<li {{ (Request::is('admin/licenses/create') ? 'class="active"' : '') }}>
							<a href="{{ route('create/licenses') }}">
								<i class="icon-plus"></i>
								@lang('general.license')</a>
						</li>
						<li {{ (Request::is('admin/users/create') ? 'class="active"' : '') }}>
							<a href="{{ route('create/user') }}">
							<i class="icon-plus"></i>
							@lang('general.user')</a>
						</li>
                    </ul>
                </li>
				@endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle hidden-xs hidden-sm" data-toggle="dropdown">
                        {{ Lang::get('general.welcome', array('name' => Sentry::getUser()->first_name)) }}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
						<li{{ (Request::is('account/profile') ? ' class="active"' : '') }}>
							<a href="{{ route('profile') }}">
								<i class="icon-user"></i> @lang('general.profile')
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
                @if(Sentry::getUser()->hasAccess('admin'))
                <li class="dropdown{{ (Request::is('admin/users*|admin/groups*') ? ' active' : '') }}  hidden-phone">
					<a class="dropdown-toggle" data-toggle="dropdown" href="{{ URL::to('admin/users') }}">
						<i class="icon-wrench icon-white"></i> @lang('general.admin') <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="{{ route('app') }}">
								<i class="icon-cog"></i> @lang('general.settings')
							</a>
						</li>
						<li{{ (Request::is('admin/groups*') ? ' class="active"' : '') }}>
							<a href="{{ URL::to('admin/groups') }}">
								<i class="icon-group"></i> @lang('general.groups')
							</a>
						</li>
						<li{{ (Request::is('admin/settings/statuslabels*') ? ' class="active"' : '') }}>
							<a href="{{ URL::to('admin/settings/statuslabels') }}">
								<i class="icon-list"></i> @lang('general.status_labels')
							</a>
						</li>
						<li{{ (Request::is('admin/settings/manufacturers*') ? ' class="active"' : '') }}>
							<a href="{{ URL::to('admin/settings/manufacturers') }}">
								<i class="icon-briefcase"></i> @lang('general.manufacturers')
							</a>
						</li>
						<li{{ (Request::is('admin/settings/categories*') ? ' class="active"' : '') }}>
							<a href="{{ URL::to('admin/settings/categories') }}">
								<i class="icon-th"></i> @lang('general.categories')
							</a>
						</li>
						<li{{ (Request::is('admin/settings/locations*') ? ' class="active"' : '') }}>
							<a href="{{ URL::to('admin/settings/locations') }}">
								<i class="icon-globe"></i> @lang('general.locations')
							</a>
						</li>
						<li{{ (Request::is('admin/settings/depreciations*') ? ' class="active"' : '') }}>
							<a href="{{ URL::to('admin/settings/depreciations') }}">
								<i class="icon-arrow-down"></i> @lang('general.depreciation')
							</a>
						</li>
					</ul>
				</li>
				@endif

			@else
					<li {{ (Request::is('auth/signin') ? 'class="active"' : '') }}><a href="{{ route('signin') }}">@lang('general.sign_in')</a></li>
            @endif
            </ul>
        </div>
    </div>
    </header>
    <!-- end navbar -->
	@if (Sentry::check())
	@if(Sentry::getUser()->hasAccess('admin'))
	<!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">

            <li{{ (Request::is('hardware*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="#" class="dropdown-toggle">
                    <i class="icon-barcode"></i>
                    <span>@lang('general.assets')</span>
                    <i class="icon-chevron-down"></i>
                </a>

                <ul class="submenu{{ (Request::is('hardware*') ? ' active' : '') }}">
                    <li><a href="{{ URL::to('hardware?Deployed=true') }}" {{ (Request::query('Deployed') ? ' class="active"' : '') }} >@lang('general.deployed')</a></li>
                    <li><a href="{{ URL::to('hardware?RTD=true') }}" {{ (Request::query('RTD') ? ' class="active"' : '') }} >@lang('general.ready_to_deploy')</a></li>
                    <li><a href="{{ URL::to('hardware?Pending=true') }}" {{ (Request::query('Pending') ? ' class="active"' : '') }} >@lang('general.pending')</a></li>
                    <li><a href="{{ URL::to('hardware?Undeployable=true') }}" {{ (Request::query('Undeployable') ? ' class="active"' : '') }} >@lang('general.undeployable')</a></li>
                    <li><a href="{{ URL::to('hardware') }}">@lang('general.list_all')</a></li>
                    <li><a href="{{ URL::to('hardware/models') }}" {{ (Request::is('hardware/models*') ? ' class="active"' : '') }} >@lang('general.asset_models')</a></li>

                </ul>
            </li>

            <li{{ (Request::is('admin/licenses*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
            	<a href="{{ URL::to('admin/licenses') }}">
            		<i class="icon-certificate"></i>
            		 <span>@lang('general.licenses')</span>
            	</a>
            </li>
            <li{{ (Request::is('admin/users*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
            	<a href="{{ URL::to('admin/users') }}">
                    <i class="icon-group"></i>
                    <span>@lang('general.people')</span>
                </a>
            </li>
            <li{{ (Request::is('reports*') ? ' class="active"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div>' : '>') }}
                <a href="{{ URL::to('reports') }}">
                    <i class="icon-signal"></i>
                    <span>@lang('general.reports')</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- end sidebar -->
	@endif
	@endif


<!-- main container -->
    <div class="content">

		@if ((Sentry::check()) && (Sentry::getUser()->hasAccess('admin')))
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
                            <a href="{{ URL::to('hardware?RTD=true') }}">
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
            </div>

        <!-- end upper main stats -->
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
        <div id="footer">
      		<div class="container">
        		<p class="muted credit"><a href="http://snipeitapp.com">Snipe IT</a> is a free open source
        		project by <a href="http://twitter.com/snipeyhead">@snipeyhead</a>. <a href="https://github.com/snipe/snipe-it">Fork it here</a>!</p>
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

    <script type="text/javascript">
        $(function () {

            $('#example').dataTable({
                "sPaginationType": "full_numbers",
                "iDisplayLength": {{ Setting::getSettings()->per_page }},
                "aLengthMenu": [[{{ Setting::getSettings()->per_page }}, -1], [{{ Setting::getSettings()->per_page }}, "All"]],
                "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 'actions' ] }]
            });

			$('#nosorting').dataTable({
                "sPaginationType": "full_numbers",
                "fnSort": [1,'asc'],
                "aoColumns": [
				{ "bSortable": false },
				{ "bSortable": false },
				{ "bSortable": false },
				{ "bSortable": false }
				],
				"iDisplayLength": {{ Setting::getSettings()->per_page }},
    			"aLengthMenu": [[{{ Setting::getSettings()->per_page }}, -1], [{{ Setting::getSettings()->per_page }}, "All"]]
            });




			// add uniform plugin styles to html elements
			$("input:checkbox, input:radio").uniform();


			// datepicker plugin
			$('.datepicker').datepicker().on('changeDate', function (ev) {
				$(this).datepicker('hide');
			});

			// select2 plugin for select elements
			$(".select2").select2({
				placeholder: "Select"
			});

            // jQuery Knobs
            $(".knob").knob();


			 $("#example").popover();


            // confirm delete modal
            $('.delete-asset').click(function(evnt) {
                var href = $(this).attr('href');
                var message = $(this).attr('data-content');
                var title = $(this).attr('data-title');

                $('#myModalLabel').text(title);
                $('#dataConfirmModal .modal-body').text(message);
                $('#dataConfirmOK').attr('href', href);
                $('#dataConfirmModal').modal({show:true});

                return false;
        	});
        });

    </script>

	</body>
</html>
