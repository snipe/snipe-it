<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
dir="{{ Helper::determineLanguageDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @section('title')
        @show
        :: {{ $snipeSettings->site_name }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <meta name="apple-mobile-web-app-capable" content="yes">


    <link rel="apple-touch-icon"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="apple-touch-startup-image"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="shortcut icon" type="image/ico"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico' }} ">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ Helper::mapBackToLegacyLocale(app()->getLocale()) }}">
    <meta name="language-direction" content="{{ Helper::determineLanguageDirection() }}">
    <meta name="baseUrl" content="{{ config('app.url') }}/">

    <script nonce="{{ csrf_token() }}">
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    </script>

    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">
    @if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
        <link rel="stylesheet" href="{{ url(mix('css/dist/skins/skin-'.Auth::user()->present()->skin.'.min.css')) }}">
    @else
        <link rel="stylesheet"
              href="{{ url(mix('css/dist/skins/skin-'.($snipeSettings->skin!='' ? $snipeSettings->skin : 'blue').'.css')) }}">
    @endif
    {{-- page level css --}}
    @stack('css')



    @if (($snipeSettings) && ($snipeSettings->header_color!=''))
        <style nonce="{{ csrf_token() }}">
            .main-header .navbar, .main-header .logo {
                background-color: {{ $snipeSettings->header_color }};
                background: -webkit-linear-gradient(top,  {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
                background: linear-gradient(to bottom, {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
                border-color: {{ $snipeSettings->header_color }};
            }

            .skin-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} .sidebar-menu > li:hover > a, .skin-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} .sidebar-menu > li.active > a {
                border-left-color: {{ $snipeSettings->header_color }};
            }

            .btn-primary {
                background-color: {{ $snipeSettings->header_color }};
                border-color: {{ $snipeSettings->header_color }};
            }
        </style>
    @endif

    {{-- Custom CSS --}}
    @if (($snipeSettings) && ($snipeSettings->custom_css))
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif


    <script nonce="{{ csrf_token() }}">
        window.snipeit = {
            settings: {
                "per_page": {{ $snipeSettings->per_page }}
            }
        };
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="{{ url(asset('js/html5shiv.js')) }}" nonce="{{ csrf_token() }}"></script>
    <script src="{{ url(asset('js/respond.js')) }}" nonce="{{ csrf_token() }}"></script>



</head>

@if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
    <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? Auth::user()->present()->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
    @else
        <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
        @endif


        <a class="skip-main" href="#main">{{ trans('general.skip_to_main_content') }}</a>
        <div class="wrapper">

            <header class="main-header">

                <div class="row" style="background: #3c8dbd;padding: 10px;">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <a class="btn bg-teal" style="width: 100%" href="#">
                                    <img height="25px" src="data:image/png;base64,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" />
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a class="btn bg-maroon" style="width: 100%" href="#">
                                    <img height="25px" src="data:image/png;base64,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" />
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a class="btn bg-orange" style="width: 100%" href="#">
                                    <img height="25px" src="data:image/png;base64,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" />
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a class="btn bg-purple" style="width: 100%" href="#">
                                    <img height="25px" src="data:image/png;base64,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" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo -->


                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button above the compact sidenav -->
                    <a href="#" style="color: white" class="sidebar-toggle btn btn-white" data-toggle="push-menu"
                       role="button">
                        <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
                    </a>
                    <div class="nav navbar-nav navbar-left">
                        <div class="left-navblock">
                            @if ($snipeSettings->brand == '3')
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    @if ($snipeSettings->logo!='')
                                        <img class="navbar-brand-img"
                                             src="{{ Storage::disk('public')->url($snipeSettings->logo) }}"
                                             alt="{{ $snipeSettings->site_name }} logo">
                                    @endif
                                    {{ $snipeSettings->site_name }}
                                </a>
                            @elseif ($snipeSettings->brand == '2')
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    @if ($snipeSettings->logo!='')
                                        <img class="navbar-brand-img"
                                             src="{{ Storage::disk('public')->url($snipeSettings->logo) }}"
                                             alt="{{ $snipeSettings->site_name }} logo">
                                    @endif
                                    <span class="sr-only">{{ $snipeSettings->site_name }}</span>
                                </a>
                            @else
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    {{ $snipeSettings->site_name }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            @can('index', \App\Models\Asset::class)
                                <li aria-hidden="true"{!! (Request::is('hardware*') ? ' class="active"' : '') !!}>
                                    <a href="{{ url('hardware') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=1" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.assets') }}">
                                        <x-icon type="assets" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.assets') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view', \App\Models\License::class)
                                <li aria-hidden="true"{!! (Request::is('licenses*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('licenses.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=2" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.licenses') }}">
                                        <x-icon type="licenses" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.licenses') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('index', \App\Models\Accessory::class)
                                <li aria-hidden="true"{!! (Request::is('accessories*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('accessories.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=3" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.accessories') }}">
                                        <x-icon type="accessories" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.accessories') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('index', \App\Models\Consumable::class)
                                <li aria-hidden="true"{!! (Request::is('consumables*') ? ' class="active"' : '') !!}>
                                    <a href="{{ url('consumables') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=4" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.consumables') }}">
                                        <x-icon type="consumables" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.consumables') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view', \App\Models\Component::class)
                                <li aria-hidden="true"{!! (Request::is('components*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('components.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=5" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.components') }}">
                                        <x-icon type="components" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.components') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('index', \App\Models\Asset::class)
                                <li>
                                    <form class="navbar-form navbar-left form-horizontal" role="search"
                                          action="{{ route('findbytag/hardware') }}" method="get">
                                        <div class="col-xs-12 col-md-12">
                                            <div class="col-xs-12 form-group">
                                                <label class="sr-only" for="tagSearch">
                                                    {{ trans('general.lookup_by_tag') }}
                                                </label>
                                                <input type="text" class="form-control" id="tagSearch" name="assetTag" placeholder="{{ trans('general.lookup_by_tag') }}">
                                                <input type="hidden" name="topsearch" value="true" id="search">
                                            </div>
                                            <div class="col-xs-1">
                                                <button type="submit" id="topSearchButton" class="btn btn-primary pull-right">
                                                    <x-icon type="search" />
                                                    <span class="sr-only">{{ trans('general.search') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            @endcan

                            @can('admin')
                                <li class="dropdown" aria-hidden="true">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                        {{ trans('general.create') }}
                                        <strong class="caret"></strong>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @can('create', \App\Models\Asset::class)
                                            <li {!! (Request::is('hardware/create') ? 'class="active>"' : '') !!}>
                                                <a href="{{ route('hardware.create') }}" tabindex="-1">
                                                    <x-icon type="assets" />
                                                    {{ trans('general.asset') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\License::class)
                                            <li {!! (Request::is('licenses/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('licenses.create') }}" tabindex="-1">
                                                    <x-icon type="licenses" />
                                                    {{ trans('general.license') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Accessory::class)
                                            <li {!! (Request::is('accessories/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('accessories.create') }}" tabindex="-1">
                                                    <x-icon type="accessories" />
                                                    {{ trans('general.accessory') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Consumable::class)
                                            <li {!! (Request::is('consunmables/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('consumables.create') }}" tabindex="-1">
                                                    <x-icon type="consumables" />
                                                    {{ trans('general.consumable') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Component::class)
                                            <li {!! (Request::is('components/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('components.create') }}" tabindex="-1">
                                                    <x-icon type="components" />
                                                    {{ trans('general.component') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\User::class)
                                            <li {!! (Request::is('users/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('users.create') }}" tabindex="-1">
                                                    <x-icon type="users" />
                                                    {{ trans('general.user') }}
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                            @can('admin')
                                @if ($snipeSettings->show_alerts_in_menu=='1')
                                    <!-- Tasks: style can be found in dropdown.less -->
                                    <?php $alert_items = Helper::checkLowInventory(); $deprecations = Helper::deprecationCheck()?>

                                    <li class="dropdown tasks-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <x-icon type="alerts" />
                                            <span class="sr-only">{{ trans('general.alerts') }}</span>
                                            @if (count($alert_items) || count($deprecations))
                                                <span class="label label-danger">{{ count($alert_items) + count($deprecations) }}</span>
                                            @endif
                                        </a>
                                        <ul class="dropdown-menu">
                                            @if($deprecations)
                                                @foreach ($deprecations as $key => $deprecation)
                                                    @if ($deprecation['check'])
                                                        <li class="header alert-warning">{!! $deprecation['message'] !!}</li>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <li class="header">{{ trans_choice('general.quantity_minimum', count($alert_items)) }}</li>
                                            <li>
                                                <!-- inner menu: contains the actual data -->
                                                <ul class="menu">

                                                    @for($i = 0; count($alert_items) > $i; $i++)

                                                        <li><!-- Task item -->
                                                            <a href="{{ route($alert_items[$i]['type'].'.show', $alert_items[$i]['id'])}}">
                                                                <h2 class="task_menu">{{ $alert_items[$i]['name'] }}
                                                                    <small class="pull-right">
                                                                        {{ $alert_items[$i]['remaining'] }} {{ trans('general.remaining') }}
                                                                    </small>
                                                                </h2>
                                                                <div class="progress xs">
                                                                    <div class="progress-bar progress-bar-yellow"
                                                                         style="width: {{ $alert_items[$i]['percent'] }}%"
                                                                         role="progressbar"
                                                                         aria-valuenow="{{ $alert_items[$i]['percent'] }}"
                                                                         aria-valuemin="0" aria-valuemax="100">
                                                                        <span class="sr-only">{{ $alert_items[$i]['percent'] }}% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <!-- end task item -->
                                                    @endfor
                                                </ul>
                                            </li>
                                            {{-- <li class="footer">
                                              <a href="#">{{ trans('general.tasks_view_all') }}</a>
                                            </li> --}}
                                        </ul>
                                    </li>
                                @endcan
                            @endif



                            <!-- User Account: style can be found in dropdown.less -->
                            @if (Auth::check())
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        @if (Auth::user()->present()->gravatar())
                                            <img src="{{ Auth::user()->present()->gravatar() }}" class="user-image"
                                                 alt="">
                                        @else
                                            <x-icon type="user" />
                                        @endif

                                        <span class="hidden-xs">
                                            {{ Auth::user()->getFullNameAttribute() }}
                                            <strong class="caret"></strong>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li {!! (Request::is('account/profile') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('view-assets') }}">
                                                <x-icon type="checkmark" class="fa-fw" />
                                                {{ trans('general.viewassets') }}
                                            </a></li>

                                        @can('viewRequestable', \App\Models\Asset::class)
                                            <li {!! (Request::is('account/requested') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('account.requested') }}">
                                                    <x-icon type="checkmark" class="fa-fw" />
                                                    {{ trans('general.requested_assets_menu') }}
                                                </a></li>
                                        @endcan

                                        <li {!! (Request::is('account/accept') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('account.accept') }}">
                                                <x-icon type="checkmark" class="fa-fw" />
                                                {{ trans('general.accept_assets_menu') }}
                                            </a></li>


                                        @can('self.profile')
                                        <li>
                                            <a href="{{ route('profile') }}">
                                                <x-icon type="user" class="fa-fw" />
                                                {{ trans('general.editprofile') }}
                                            </a>
                                        </li>
                                        @endcan

                                        @if (Auth::user()->ldap_import!='1')
                                        <li>
                                            <a href="{{ route('account.password.index') }}">
                                                <x-icon type="password" class="fa-fw" />
                                                {{ trans('general.changepassword') }}
                                            </a>
                                        </li>
                                        @endif


                                        @can('self.api')
                                            <li>
                                                <a href="{{ route('user.api') }}">
                                                    <x-icon type="api-key" class="fa-fw" />
                                                     {{ trans('general.manage_api_keys') }}
                                                </a>
                                            </li>
                                        @endcan
                                        <li class="divider" style="margin-top: -1px; margin-bottom: -1px"></li>
                                        <li>

                                            <a href="{{ route('logout.get') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <x-icon type="logout" class="fa-fw" />
                                                 {{ trans('general.logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout.post') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>

                                        </li>
                                    </ul>
                                </li>
                            @endif


                            @can('superadmin')
                                <li>
                                    <a href="{{ route('settings.index') }}">
                                        <x-icon type="admin-settings" />
                                        <span class="sr-only">{{ trans('general.admin') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </nav>
                <a href="#" style="float:left" class="sidebar-toggle-mobile visible-xs btn" data-toggle="push-menu"
                   role="button">
                    <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
                    <x-icon type="nav-toggle" />
                </a>
                <!-- Sidebar toggle button-->
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree" {{ \App\Helpers\Helper::determineLanguageDirection() == 'rtl' ? 'style="margin-right:12px' : '' }}>
                        @can('admin')
                            <li {!! (\Request::route()->getName()=='home' ? ' class="active"' : '') !!} class="firstnav">
                                <a href="{{ route('home') }}">
                                    <x-icon type="dashboard" class="fa-fw" />
                                    <span>{{ trans('general.dashboard') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('index', \App\Models\Asset::class)
                            <li class="treeview{{ ((Request::is('statuslabels/*') || Request::is('hardware*')) ? ' active' : '') }}">
                                <a href="#">
                                    <x-icon type="assets" class="fa-fw" />
                                    <span>{{ trans('general.assets') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ url('hardware') }}">
                                            <x-icon type="circle" class="text-grey fa-fw"/>
                                            {{ trans('general.list_all') }}
                                            <span class="badge">
                                                {{ (isset($total_assets)) ? $total_assets : '' }}
                                            </span>
                                        </a>
                                    </li>

                                    <?php $status_navs = \App\Models\Statuslabel::where('show_in_nav', '=', 1)->withCount('assets as asset_count')->get(); ?>
                                    @if (count($status_navs) > 0)
                                        @foreach ($status_navs as $status_nav)
                                            <li{!! (Request::is('statuslabels/'.$status_nav->id) ? ' class="active"' : '') !!}>
                                                <a href="{{ route('statuslabels.show', ['statuslabel' => $status_nav->id]) }}">
                                                    <i class="fas fa-circle text-grey fa-fw"
                                                       aria-hidden="true"{!!  ($status_nav->color!='' ? ' style="color: '.e($status_nav->color).'"' : '') !!}></i>
                                                    {{ $status_nav->name }}
                                                    <span class="badge badge-secondary">{{ $status_nav->asset_count }}</span></a></li>
                                        @endforeach
                                    @endif


                                    <li{!! (Request::query('status') == 'Deployed' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=Deployed') }}">
                                            <x-icon type="circle" class="text-blue fa-fw" />
                                            {{ trans('general.deployed') }}
                                            <span class="badge">{{ (isset($total_deployed_sidebar)) ? $total_deployed_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li{!! (Request::query('status') == 'RTD' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=RTD') }}">
                                            <x-icon type="circle" class="text-green fa-fw" />
                                            {{ trans('general.ready_to_deploy') }}
                                            <span class="badge">{{ (isset($total_rtd_sidebar)) ? $total_rtd_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li{!! (Request::query('status') == 'Pending' ? ' class="active"' : '') !!}><a href="{{ url('hardware?status=Pending') }}">
                                            <x-icon type="circle" class="text-orange fa-fw" />
                                            {{ trans('general.pending') }}
                                            <span class="badge">{{ (isset($total_pending_sidebar)) ? $total_pending_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li{!! (Request::query('status') == 'Undeployable' ? ' class="active"' : '') !!} ><a
                                                href="{{ url('hardware?status=Undeployable') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.undeployable') }}
                                            <span class="badge">{{ (isset($total_undeployable_sidebar)) ? $total_undeployable_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li{!! (Request::query('status') == 'byod' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=byod') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.byod') }}
                                            <span class="badge">{{ (isset($total_byod_sidebar)) ? $total_byod_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li{!! (Request::query('status') == 'Archived' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Archived') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('admin/hardware/general.archived') }}
                                            <span class="badge">{{ (isset($total_archived_sidebar)) ? $total_archived_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li{!! (Request::query('status') == 'Requestable' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Requestable') }}">
                                            <x-icon type="checkmark" class="text-blue fa-fw" />
                                            {{ trans('admin/hardware/general.requestable') }}
                                        </a>
                                    </li>

                                    @can('audit', \App\Models\Asset::class)
                                        <li{!! (Request::is('hardware/audit/due') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.audit.due') }}">
                                                <x-icon type="due" class="text-yellow fa-fw"/>
                                                {{ trans('general.audit_due') }}
                                                <span class="badge">{{ (isset($total_due_and_overdue_for_audit)) ? $total_due_and_overdue_for_audit : '' }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkin', \App\Models\Asset::class)
                                    <li{!! (Request::is('hardware/checkins/due') ? ' class="active"' : '') !!}>
                                        <a href="{{ route('assets.checkins.due') }}">
                                            <x-icon type="due" class="text-orange fa-fw"/>
                                            {{ trans('general.checkin_due') }}
                                            <span class="badge">{{ (isset($total_due_and_overdue_for_checkin)) ? $total_due_and_overdue_for_checkin : '' }}</span>
                                        </a>
                                    </li>
                                    @endcan

                                    <li class="divider">&nbsp;</li>
                                    @can('checkin', \App\Models\Asset::class)
                                        <li{!! (Request::is('hardware/quickscancheckin') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware/quickscancheckin') }}">
                                                {{ trans('general.quickscan_checkin') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkout', \App\Models\Asset::class)
                                        <li{!! (Request::is('hardware/bulkcheckout') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware.bulkcheckout.show') }}">
                                                {{ trans('general.bulk_checkout') }}
                                            </a>
                                        </li>
                                        <li{!! (Request::is('hardware/requested') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.requested') }}">
                                                {{ trans('general.requested') }}</a>
                                        </li>
                                    @endcan

                                    @can('create', \App\Models\Asset::class)
                                        <li{!! (Request::query('Deleted') ? ' class="active"' : '') !!}>
                                            <a href="{{ url('hardware?status=Deleted') }}">
                                                {{ trans('general.deleted') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maintenances.index') }}">
                                                {{ trans('general.asset_maintenances') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin')
                                        <li>
                                            <a href="{{ url('hardware/history') }}">
                                                {{ trans('general.import-history') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('audit', \App\Models\Asset::class)
                                        <li>
                                            <a href="{{ route('assets.bulkaudit') }}">
                                                {{ trans('general.bulkaudit') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('view', \App\Models\License::class)
                            <li{!! (Request::is('licenses*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('licenses.index') }}">
                                    <x-icon type="licenses" class="fa-fw"/>
                                    <span>{{ trans('general.licenses') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('index', \App\Models\Accessory::class)
                            <li{!! (Request::is('accessories*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('accessories.index') }}">
                                    <x-icon type="accessories" class="fa-fw" />
                                    <span>{{ trans('general.accessories') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Consumable::class)
                            <li{!! (Request::is('consumables*') ? ' class="active"' : '') !!}>
                                <a href="{{ url('consumables') }}">
                                    <x-icon type="consumables" class="fa-fw" />
                                    <span>{{ trans('general.consumables') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Component::class)
                            <li{!! (Request::is('components*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('components.index') }}">
                                    <x-icon type="components" class="fa-fw" />
                                    <span>{{ trans('general.components') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\PredefinedKit::class)
                            <li{!! (Request::is('kits') ? ' class="active"' : '') !!}>
                                <a href="{{ route('kits.index') }}">
                                    <x-icon type="kits" class="fa-fw" />
                                    <span>{{ trans('general.kits') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('view', \App\Models\User::class)
                            <li{!! (Request::is('users*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('users.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=6" : ''}}>
                                    <x-icon type="users" class="fa-fw" />
                                    <span>{{ trans('general.people') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('import')
                            <li{!! (Request::is('import/*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('imports.index') }}">
                                    <x-icon type="import" class="fa-fw" />
                                    <span>{{ trans('general.import') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('backend.interact')
                            <li class="treeview {!! in_array(Request::route()->getName(),App\Helpers\Helper::SettingUrls()) ? ' active': '' !!}">
                                <a href="#" id="settings">
                                    <x-icon type="settings" class="fa-fw" />
                                    <span>{{ trans('general.settings') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>

                                <ul class="treeview-menu">
                                    @if(Gate::allows('view', App\Models\CustomField::class) || Gate::allows('view', App\Models\CustomFieldset::class))
                                        <li {!! (Request::is('fields*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('fields.index') }}">
                                                {{ trans('admin/custom_fields/general.custom_fields') }}
                                            </a>
                                        </li>
                                    @endif

                                    @can('view', \App\Models\Statuslabel::class)
                                        <li {!! (Request::is('statuslabels*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('statuslabels.index') }}">
                                                {{ trans('general.status_labels') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\AssetModel::class)
                                        <li>
                                            <a href="{{ route('models.index') }}" {{ (Request::is('/assetmodels') ? ' class="active"' : '') }}>
                                                {{ trans('general.asset_models') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Category::class)
                                        <li>
                                            <a href="{{ route('categories.index') }}" {{ (Request::is('/categories') ? ' class="active"' : '') }}>
                                                {{ trans('general.categories') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Manufacturer::class)
                                        <li>
                                            <a href="{{ route('manufacturers.index') }}" {{ (Request::is('/manufacturers') ? ' class="active"' : '') }}>
                                                {{ trans('general.manufacturers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Supplier::class)
                                        <li>
                                            <a href="{{ route('suppliers.index') }}" {{ (Request::is('/suppliers') ? ' class="active"' : '') }}>
                                                {{ trans('general.suppliers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Department::class)
                                        <li>
                                            <a href="{{ route('departments.index') }}" {{ (Request::is('/departments') ? ' class="active"' : '') }}>
                                                {{ trans('general.departments') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Location::class)
                                        <li>
                                            <a href="{{ route('locations.index') }}" {{ (Request::is('/locations') ? ' class="active"' : '') }}>
                                                {{ trans('general.locations') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Company::class)
                                        <li>
                                            <a href="{{ route('companies.index') }}" {{ (Request::is('/companies') ? ' class="active"' : '') }}>
                                                {{ trans('general.companies') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Depreciation::class)
                                        <li>
                                            <a href="{{ route('depreciations.index') }}" {{ (Request::is('/depreciations') ? ' class="active"' : '') }}>
                                                {{ trans('general.depreciation') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('reports.view')
                            <li class="treeview{{ (Request::is('reports*') ? ' active' : '') }}">
                                <a href="#" class="dropdown-toggle">
                                    <x-icon type="reports" class="fa-fw" />
                                    <span>{{ trans('general.reports') }}</span>
                                    <x-icon type="angle-left" class="pull-right"/>
                                </a>

                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ route('reports.activity') }}" {{ (Request::is('reports/activity') ? ' class="active"' : '') }}>
                                            {{ trans('general.activity_report') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reports/custom') }}" {{ (Request::is('reports/custom') ? ' class="active"' : '') }}>
                                            {{ trans('general.custom_report') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reports.audit') }}" {{ (Request::is('reports.audit') ? ' class="active"' : '') }}>
                                            {{ trans('general.audit_report') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reports/depreciation') }}" {{ (Request::is('reports/depreciation') ? ' class="active"' : '') }}>
                                            {{ trans('general.depreciation_report') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reports/licenses') }}" {{ (Request::is('reports/licenses') ? ' class="active"' : '') }}>
                                            {{ trans('general.license_report') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reports/asset_maintenances') }}" {{ (Request::is('reports/asset_maintenances') ? ' class="active"' : '') }}>
                                            {{ trans('general.asset_maintenance_report') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reports/unaccepted_assets') }}" {{ (Request::is('reports/unaccepted_assets') ? ' class="active"' : '') }}>
                                            {{ trans('general.unaccepted_asset_report') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('reports/accessories') }}" {{ (Request::is('reports/accessories') ? ' class="active"' : '') }}>
                                            {{ trans('general.accessory_report') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('viewRequestable', \App\Models\Asset::class)
                            <li{!! (Request::is('account/requestable-assets') ? ' class="active"' : '') !!}>
                                <a href="{{ route('requestable-assets') }}">
                                    <x-icon type="requestable" class="fa-fw" />
                                    <span>{{ trans('general.requestable_items') }}</span>
                                </a>
                            </li>
                        @endcan


                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->

            <div class="content-wrapper" role="main" id="setting-list">
                <barepay></barepay>

                @if ($debug_in_production)
                    <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                        <div class="col-md-12"
                             style="margin-bottom: 0px; background-color: #b50408 ; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
                            <x-icon type="warning" class="fa-3x pull-left"/>
                            <strong>{{ strtoupper(trans('general.debug_warning')) }}:</strong>
                            {!! trans('general.debug_warning_text') !!}
                        </div>
                    </div>
                @endif

                <!-- Content Header (Page header) -->
                <section class="content-header" style="padding-bottom: 30px;">
                    <h1 class="pull-left pagetitle">@yield('title') </h1>

                    @if (isset($helpText))
                        @include ('partials.more-info',
                                               [
                                                   'helpText' => $helpText,
                                                   'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                                               ])
                    @endif
                    <div class="pull-right">
                        @yield('header_right')
                    </div>


                </section>


                <section class="content" id="main" tabindex="-1">

                    <!-- Notifications -->
                    <div class="row">
                        @if (config('app.lock_passwords'))
                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    {{ trans('general.some_features_disabled') }}
                                </div>
                            </div>
                        @endif

                        @include('notifications')
                    </div>


                    <!-- Content -->
                    <div id="{!! (Request::is('*api*') ? 'app' : 'webui') !!}">
                        @yield('content')
                    </div>

                </section>

            </div><!-- /.content-wrapper -->
            <footer class="main-footer hidden-print" style="display:grid;flex-direction:column;">

                <div class="1hidden-xs pull-left">
                    <div class="pull-left" >
                        <a target="_blank" href="https://snipeitapp.com" rel="noopener">Snipe-IT</a> is open source software, made with <x-icon type="heart" style="color: #a94442; font-size: 10px" />
                            <span class="sr-only">love</span> by <a href="https://bsky.app/profile/snipeitapp.com" rel="noopener">@snipeitapp</a>.
                    </div>
                    <div class="pull-right">
                    @if ($snipeSettings->version_footer!='off')
                        @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            &nbsp; <strong>Version</strong> {{ config('version.app_version') }} -
                            build {{ config('version.build_version') }} ({{ config('version.branch') }})
                        @endif
                    @endif

                    @if ($snipeSettings->support_footer!='off')
                        @if (($snipeSettings->support_footer=='on') || (($snipeSettings->support_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            <a target="_blank" class="btn btn-default btn-xs"
                               href="https://snipe-it.readme.io/docs/overview"
                               rel="noopener">{{ trans('general.user_manual') }}</a>
                            <a target="_blank" class="btn btn-default btn-xs" href="https://snipeitapp.com/support/"
                               rel="noopener">{{ trans('general.bug_report') }}</a>
                        @endif
                    @endif

                    @if ($snipeSettings->privacy_policy_link!='')
                        <a target="_blank" class="btn btn-default btn-xs" rel="noopener"
                           href="{{  $snipeSettings->privacy_policy_link }}"
                           target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
                    @endif
                    </div>
                    <br>
                    @if ($snipeSettings->footer_text!='')
                        <div class="pull-left">
                            {!!  Helper::parseEscapedMarkedown($snipeSettings->footer_text)  !!}
                        </div>
                    @endif
                </div>
            </footer>
        </div><!-- ./wrapper -->


        <!-- end main container -->

        <div class="modal modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h2 class="modal-title" id="myModalLabel">&nbsp;</h2>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="deleteForm" role="form">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal modal-warning fade" id="restoreConfirmModal" tabindex="-1" role="dialog"
             aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="confirmModalLabel">&nbsp;</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="restoreForm" role="form">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        {{-- Javascript files --}}
        <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
        <script src="{{ url('js/select2/i18n/'.Helper::mapBackToLegacyLocale(app()->getLocale()).'.js') }}"></script>

        <!-- v5-beta: This pGenerator call must remain here for v5 - until fixed - so that the JS password generator works for the user create modal. -->
        <script src="{{ url('js/pGenerator.jquery.js') }}"></script>

        {{-- Page level javascript --}}
        @stack('js')

        @section('moar_scripts')
        @show


        <script nonce="{{ csrf_token() }}">

            var clipboard = new ClipboardJS('.js-copy-link');

            clipboard.on('success', function(e) {
                // Get the clicked element
                var clickedElement = $(e.trigger);
                // Get the target element selector from data attribute
                var targetSelector = clickedElement.data('data-clipboard-target');
                // Show the alert that the content was copied
                clickedElement.tooltip('hide').attr('data-original-title', '{{ trans('general.copied') }}').tooltip('show');
            });

            // Reference: https://jqueryvalidation.org/validate/
            var validator = $('#create-form').validate({
                ignore: 'input[type=hidden]',
                errorClass: 'alert-msg',
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    $(element).hasClass('select2') || $(element).hasClass('js-data-ajax')
                        // If the element is a select2 then append the error to the parent div
                        ? element.parent('div').append(error)
                        // Otherwise place it after
                        : error.insertAfter(element);
                },
                highlight: function(inputElement) {
                    $(inputElement).parent().addClass('has-error');
                    $(inputElement).closest('.help-block').remove();
                },
                onfocusout: function(element) {
                    return $(element).valid();
                },

            });

            $.extend($.validator.messages, {
                required: "{{ trans('validation.generic.required') }}",
                email: "{{ trans('validation.generic.email') }}"
            });


            function showHideEncValue(e) {
                // Use element id to find the text element to hide / show
                var targetElement = e.id+"-to-show";
                var hiddenElement = e.id+"-to-hide";
                var audio = new Audio('{{ config('app.url') }}/sounds/lock.mp3');
                if($(e).hasClass('fa-lock')) {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-lock').addClass('fa-unlock');
                    // Show the encrypted custom value and hide the element with asterisks
                    document.getElementById(targetElement).style.fontSize = "100%";
                    document.getElementById(hiddenElement).style.display = "none";

                } else {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-unlock').addClass('fa-lock');
                    // ClipboardJS can't copy display:none elements so use a trick to hide the value
                    document.getElementById(targetElement).style.fontSize = "0px";
                    document.getElementById(hiddenElement).style.display = "";

                 }
             }

            $(function () {

                // Invoke Bootstrap 3's tooltip
                $('[data-tooltip="true"]').tooltip({
                    container: 'body',
                    animation: true,
                });

                $('[data-toggle="popover"]').popover();
                $('.select2 span').addClass('needsclick');
                $('.select2 span').removeAttr('title');

                // This javascript handles saving the state of the menu (expanded or not)
                $('body').bind('expanded.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'open']) }}",
                        _token: "{{ csrf_token() }}"
                    });

                });

                $('body').bind('collapsed.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'close']) }}",
                        _token: "{{ csrf_token() }}"
                    });
                });

            });

            // Initiate the ekko lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
            //This prevents multi-click checkouts for accessories, components, consumables
            $(document).ready(function () {
                $('#checkout_form').submit(function (event) {
                    event.preventDefault();
                    $('#submit_button').prop('disabled', true);
                    this.submit();
                });
            });

            // Select encrypted custom fields to hide them in the asset list
            $(document).ready(function() {
                // Selector for elements with css-padlock class
                var selector = 'td.css-padlock';

                // Function to add original value to elements
                function addValue($element) {
                    // Get original value of the element
                    var originalValue = $element.text().trim();

                    // Show asterisks only for not empty values
                    if (originalValue !== '') {
                        // This is necessary to avoid loop because value is generated dynamically
                        if (originalValue !== '' && originalValue !== asterisks) $element.attr('value', originalValue);

                        // Hide the original value and show asterisks of the same length
                        var asterisks = '*'.repeat(originalValue.length);
                        $element.text(asterisks);

                        // Add click event to show original text
                        $element.click(function() {
                            var $this = $(this);
                            if ($this.text().trim() === asterisks) {
                                $this.text($this.attr('value'));
                            } else {
                                $this.text(asterisks);
                            }
                        });
                    }
                }
                // Add value to existing elements
                $(selector).each(function() {
                    addValue($(this));
                });

                // Function to handle mutations in the DOM because content is generated dynamically
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        // Check if new nodes have been inserted
                        if (mutation.type === 'childList') {
                            mutation.addedNodes.forEach(function(node) {
                                if ($(node).is(selector)) {
                                    addValue($(node));
                                } else {
                                    $(node).find(selector).each(function() {
                                        addValue($(this));
                                    });
                                }
                            });
                        }
                    });
                });

                // Configure the observer to observe changes in the DOM
                var config = { childList: true, subtree: true };
                observer.observe(document.body, config);
            });


        </script>

        @if ((Session::get('topsearch')=='true') || (Request::is('/')))
            <script nonce="{{ csrf_token() }}">
                $("#tagSearch").focus();
            </script>
        @endif

        </body>
</html>
