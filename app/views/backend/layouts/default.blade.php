<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			Administration
			@show
		</title>
		<meta name="keywords" content="your, awesome, keywords, here" />
		<meta name="author" content="Jon Doe" />
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/bootstrap-responsive.css') }}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/datepicker.css') }}">

		<style>
		@section('styles')
		body {
			padding: 60px 0;
		}
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}">

		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">
	</head>

	<body>
		<!-- Container -->
		<div class="container">
			<!-- Header thingie will go here -->

			<!-- Navbar -->

			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<div class="nav-collapse collapse">
							<ul class="nav">
							<li{{ (Request::is('admin') ? ' class="active"' : '') }}><a href="{{ URL::to('admin') }}"><i class="icon-home icon-white"></i> Dashboard</a></li>
							<li{{ (Request::is('assets/assets') ? ' class="active"' : '') }}><a href="{{ URL::to('assets/assets') }}"><i class="icon-barcode icon-white"></i> Assets</a></li>
							<li{{ (Request::is('assets/models') ? ' class="active"' : '') }}><a href="{{ URL::to('assets/models') }}"><i class="icon-th-list icon-white"></i> Models</a></li>
							<li{{ (Request::is('admin/users') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/users') }}"><i class="icon-user icon-white"></i> People</a></li>
							<li{{ (Request::is('admin/licenses') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/licenses') }}"><i class="icon-certificate icon-white"></i> Licenses</a></li>
							<li{{ (Request::is('assets/people') ? ' class="active"' : '') }}><a href="{{ URL::to('assets/models') }}"><i class="icon-signal icon-white"></i> Reports</a></li>
							</ul>


							<ul class="nav pull-right">

								<li class="divider-vertical"></li>


									<li class="dropdown{{ (Request::is('admin/users*|admin/groups*') ? ' active' : '') }}">
										<a class="dropdown-toggle" data-toggle="dropdown" href="{{ URL::to('admin/users') }}">
											<i class="icon-wrench icon-white"></i> Admin <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li{{ (Request::is('admin/groups*') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/groups') }}"><i class="icon-user"></i> Groups</a></li>
											<li{{ (Request::is('admin/settings/manufacturers*') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/settings/manufacturers') }}"><i class="icon-briefcase"></i> Manufacturers</a></li>
											<li{{ (Request::is('admin/settings/categories*') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/settings/categories') }}"><i class="icon-th"></i> Categories</a></li>

											<li{{ (Request::is('admin/groups*') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/groups') }}"><i class="icon-arrow-down"></i> Depreciation</a></li>

										</ul>
									</li>
								<li><a href="{{ route('logout') }}"> <i class="icon-off icon-white"></i> Logout</a></li>


							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Notifications -->
			@include('frontend/notifications')

			<!-- Content -->
			@yield('content')
		</div>

		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('assets/js/jquery.1.10.2.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>

		<script type="text/javascript">
			$(document).ready(function() {
    		$('.datepicker').datepicker();
			});
		</script>
	</body>
</html>
