<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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



      <link rel="apple-touch-icon" href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) : '/img/logo.png' }}">
      <link rel="apple-touch-startup-image" href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) : '/img/logo.png' }}">
      <link rel="shortcut icon" type="image/ico" href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : '/favicon.ico' }} ">


      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="baseUrl" content="{{ url('/') }}/">

    <script nonce="{{ csrf_token() }}">
      window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    </script>

    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">
    @if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
        <link rel="stylesheet" href="{{ url(mix('css/dist/skins/skin-'.Auth::user()->present()->skin.'.min.css')) }}">
    @else
    <link rel="stylesheet" href="{{ url(mix('css/dist/skins/skin-'.($snipeSettings->skin!='' ? $snipeSettings->skin : 'blue').'.css')) }}">
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
    <!-- Add laravel routes into javascript  Primarily useful for vue.-->
    @routes

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <script src="{{ url(asset('js/html5shiv.js')) }}" nonce="{{ csrf_token() }}"></script>
        <script src="{{ url(asset('js/respond.js')) }}" nonce="{{ csrf_token() }}"></script>


  </head>

  @if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
      <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? Auth::user()->present()->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
  @else
      <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
  @endif

  <a class="skip-main" href="#main">Skip to main content</a>
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->


        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button above the compact sidenav -->
          <a href="#" style="color: white" class="sidebar-toggle btn btn-white" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="nav navbar-nav navbar-left">
              <div class="left-navblock">
                 @if ($snipeSettings->brand == '3')
                      <a class="logo navbar-brand no-hover" href="{{ url('/') }}">
                          @if ($snipeSettings->logo!='')
                          <img class="navbar-brand-img" src="{{ Storage::disk('public')->url($snipeSettings->logo) }}" alt="{{ $snipeSettings->site_name }} logo">
                          @endif
                          {{ $snipeSettings->site_name }}
                      </a>
                  @elseif ($snipeSettings->brand == '2')
                      <a class="logo navbar-brand no-hover" href="{{ url('/') }}">
                          @if ($snipeSettings->logo!='')
                            <img class="navbar-brand-img" src="{{ Storage::disk('public')->url($snipeSettings->logo) }}" alt="{{ $snipeSettings->site_name }} logo">
                          @endif
                          <span class="sr-only">{{ $snipeSettings->site_name }}</span>
                      </a>
                  @else
                      <a class="logo navbar-brand no-hover" href="{{ url('/') }}">
                          {{ $snipeSettings->site_name }}
                      </a>
                  @endif
              </div>
            </div>


          <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                  @can('index', \App\Models\Asset::class)
                  <li aria-hidden="true"{!! (Request::is('hardware*') ? ' class="active"' : '') !!} tabindex="-1">
                      <a href="{{ url('hardware') }}" tabindex="-1">
                          <i class="fa fa-barcode" aria-hidden="true"></i>
                          <span class="sr-only">Assets</span>
                      </a>
                  </li>
                  @endcan
                  @can('view', \App\Models\License::class)
                  <li aria-hidden="true"{!! (Request::is('licenses*') ? ' class="active"' : '') !!} tabindex="-1">
                      <a href="{{ route('licenses.index') }}" tabindex="-1">
                          <i class="fa fa-floppy-o"></i>
                          <span class="sr-only">Licenses</span>
                      </a>
                  </li>
                  @endcan
                  @can('index', \App\Models\Accessory::class)
                  <li aria-hidden="true"{!! (Request::is('accessories*') ? ' class="active"' : '') !!} tabindex="-1">
                      <a href="{{ route('accessories.index') }}" tabindex="-1">
                          <i class="fa fa-keyboard-o"></i>
                          <span class="sr-only">Accessories</span>
                      </a>
                  </li>
                  @endcan
                  @can('index', \App\Models\Consumable::class)
                  <li aria-hidden="true"{!! (Request::is('consumables*') ? ' class="active"' : '') !!}>
                      <a href="{{ url('consumables') }}" tabindex="-1">
                          <i class="fa fa-tint"></i>
                          <span class="sr-only">Consumables</span>
                      </a>
                  </li>
                  @endcan
                  @can('view', \App\Models\Component::class)
                  <li aria-hidden="true"{!! (Request::is('components*') ? ' class="active"' : '') !!}>
                      <a href="{{ route('components.index') }}" tabindex="-1">
                          <i class="fa fa-hdd-o"></i>
                          <span class="sr-only">Components</span>
                      </a>
                  </li>
                  @endcan

                  @can('index', \App\Models\Asset::class)
                  <li>
                  <form class="navbar-form navbar-left form-horizontal" role="search" action="{{ route('findbytag/hardware') }}" method="get">
                      <div class="col-xs-12 col-md-12">
                          <div class="col-xs-12 form-group">
                              <label class="sr-only" for="tagSearch">{{ trans('general.lookup_by_tag') }}</label>
                              <input type="text" class="form-control" id="tagSearch" name="assetTag" placeholder="{{ trans('general.lookup_by_tag') }}">
                              <input type="hidden" name="topsearch" value="true" id="search">
                          </div>
                          <div class="col-xs-1">
                              <button type="submit" class="btn btn-primary pull-right">
                                  <i class="fa fa-search" aria-hidden="true"></i>
                                  <span class="sr-only">Search</span>
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
                                  <i class="fa fa-barcode fa-fw" aria-hidden="true"></i>
                                  {{ trans('general.asset') }}
                              </a>
                      </li>
                       @endcan
                       @can('create', \App\Models\License::class)
                       <li {!! (Request::is('licenses/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('licenses.create') }}" tabindex="-1">
                               <i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>
                               {{ trans('general.license') }}
                           </a>
                       </li>
                       @endcan
                       @can('create', \App\Models\Accessory::class)
                       <li {!! (Request::is('accessories/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('accessories.create') }}" tabindex="-1">
                               <i class="fa fa-keyboard-o fa-fw" aria-hidden="true"></i>
                               {{ trans('general.accessory') }}</a>
                       </li>
                       @endcan
                       @can('create', \App\Models\Consumable::class)
                       <li {!! (Request::is('consunmables/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('consumables.create') }}" tabindex="-1">
                               <i class="fa fa-tint fa-fw" aria-hidden="true"></i>
                               {{ trans('general.consumable') }}
                           </a>
                       </li>
                       @endcan
                       @can('create', \App\Models\Component::class)
                       <li {!! (Request::is('components/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('components.create') }}" tabindex="-1">
                           <i class="fa fa-hdd-o fa-fw" aria-hidden="true"></i>
                           {{ trans('general.component') }}
                           </a>
                       </li>
                       @endcan
                         @can('create', \App\Models\User::class)
                             <li {!! (Request::is('users/create') ? 'class="active"' : '') !!}>
                                 <a href="{{ route('users.create') }}" tabindex="-1">
                                     <i class="fa fa-user fa-fw" aria-hidden="true"></i>
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
               <?php $alert_items = \App\Helpers\Helper::checkLowInventory(); ?>

               <li class="dropdown tasks-menu">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="fa fa-flag-o" aria-hidden="true"></i>
                     <span class="sr-only">Alerts</span>
                   @if (count($alert_items))
                    <span class="label label-danger">{{ count($alert_items) }}</span>
                   @endif
                 </a>
                 <ul class="dropdown-menu">
                   <li class="header">You have {{ count($alert_items) }} items below or almost below minimum quantity levels</li>
                   <li>
                     <!-- inner menu: contains the actual data -->
                     <ul class="menu">

                      @for($i = 0; count($alert_items) > $i; $i++)

                        <li><!-- Task item -->
                          <a href="{{route($alert_items[$i]['type'].'.show', $alert_items[$i]['id'])}}">
                            <h2>{{ $alert_items[$i]['name'] }}
                              <small class="pull-right">
                                {{ $alert_items[$i]['remaining'] }} remaining
                              </small>
                            </h2>
                            <div class="progress xs">
                              <div class="progress-bar progress-bar-yellow" style="width: {{ $alert_items[$i]['percent'] }}%" role="progressbar" aria-valuenow="{{ $alert_items[$i]['percent'] }}" aria-valuemin="0" aria-valuemax="100">
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
                     <a href="#">View all tasks</a>
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
                       <img src="{{ Auth::user()->present()->gravatar() }}" class="user-image" alt="">
                   @else
                      <i class="fa fa-user fa-fws" aria-hidden="true"></i>
                   @endif

                   <span class="hidden-xs">{{ Auth::user()->first_name }} <strong class="caret"></strong></span>
                 </a>
                 <ul class="dropdown-menu">
                   <!-- User image -->
                     <li {!! (Request::is('account/profile') ? ' class="active"' : '') !!}>
                       <a href="{{ route('view-assets') }}">
                             <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                             {{ trans('general.viewassets') }}
                       </a></li>

                     <li {!! (Request::is('account/requested') ? ' class="active"' : '') !!}>
                         <a href="{{ route('account.requested') }}">
                             <i class="fa fa-check fa-disk fa-fw" aria-hidden="true"></i>
                             Requested Assets
                         </a></li>
                     <li {!! (Request::is('account/accept') ? ' class="active"' : '') !!}>
                         <a href="{{ route('account.accept') }}">
                             <i class="fa fa-check fa-disk fa-fw"></i>
                             Accept Assets
                         </a></li>



                     <li>
                          <a href="{{ route('profile') }}">
                             <i class="fa fa-user fa-fw" aria-hidden="true"></i>
                              {{ trans('general.editprofile') }}
                         </a>
                     </li>
                     <li>
                         <a href="{{ route('account.password.index') }}">
                             <i class="fa fa-asterisk fa-fw" aria-hidden="true"></i>
                             {{ trans('general.changepassword') }}
                         </a>
                     </li>



                     @can('self.api')
                     <li>
                         <a href="{{ route('user.api') }}">
                             <i class="fa fa-user-secret fa-fw" aria-hidden="true"></i> Manage API Keys
                         </a>
                     </li>
                     @endcan
                     <li class="divider"></li>
                     <li>

                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-fw"></i> {{ trans('general.logout') }}
                                    {{ csrf_field() }}
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    
                     </li>
                 </ul>
               </li>
               @endif


               @can('superadmin')
               <li>
                   <a href="{{ route('settings.index') }}">
                       <i class="fa fa-cogs fa-fw" aria-hidden="true"></i>
                       <span class="sr-only">{{ trans('general.admin') }}</span>
                   </a>
               </li>
               @endcan
            </ul>
          </div>
      </nav>
       <a href="#" style="float:left" class="sidebar-toggle-mobile visible-xs btn" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <i class="fa fa-bars"></i>
      </a>
       <!-- Sidebar toggle button-->
      </header>

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            @can('admin')
            <li {!! (\Request::route()->getName()=='home' ? ' class="active"' : '') !!}>
              <a href="{{ route('home') }}">
                <i class="fa fa-dashboard" aria-hidden="true"></i> <span>{{ trans('general.dashboard') }}</span>
              </a>
            </li>
            @endcan
            @can('index', \App\Models\Asset::class)
            <li class="treeview{{ (Request::is('hardware*') ? ' active' : '') }}">
                <a href="#"><i class="fa fa-barcode" aria-hidden="true"></i>
                  <span>{{ trans('general.assets') }}</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                      <a href="{{ url('hardware') }}">
                          <i class="fa fa-circle-o text-grey" aria-hidden="true"></i>
                        {{ trans('general.list_all') }}
                    </a>
                  </li>

                    <?php $status_navs = \App\Models\Statuslabel::where('show_in_nav', '=', 1)->withCount('assets as asset_count')->get(); ?>
                    @if (count($status_navs) > 0)
                        @foreach ($status_navs as $status_nav)
                            <li><a href="{{ route('statuslabels.show', ['statuslabel' => $status_nav->id]) }}"><i class="fa fa-circle text-grey" aria-hidden="true"></i> {{ $status_nav->name }} ({{ $status_nav->asset_count }})</a></li>
                        @endforeach
                    @endif


                  <li{!! (Request::query('status') == 'Deployed' ? ' class="active"' : '') !!}>
                    <a href="{{ url('hardware?status=Deployed') }}">
                        <i class="fa fa-circle-o text-blue"></i>
                        {{ trans('general.all') }}
                        {{ trans('general.deployed') }}
                        ({{ (isset($total_deployed_sidebar)) ? $total_deployed_sidebar : '' }})
                    </a>
                  </li>
                  <li{!! (Request::query('status') == 'RTD' ? ' class="active"' : '') !!}>
                    <a href="{{ url('hardware?status=RTD') }}">
                        <i class="fa fa-circle-o text-green"></i>
                        {{ trans('general.all') }}
                        {{ trans('general.ready_to_deploy') }}
                        ({{ (isset($total_rtd_sidebar)) ? $total_rtd_sidebar : '' }})
                    </a>
                  </li>
                  <li{!! (Request::query('status') == 'Pending' ? ' class="active"' : '') !!}><a href="{{ url('hardware?status=Pending') }}"><i class="fa fa-circle-o text-orange"></i>
                          {{ trans('general.all') }}
                          {{ trans('general.pending') }}
                          ({{ (isset($total_pending_sidebar)) ? $total_pending_sidebar : '' }})
                      </a>
                  </li>
                  <li{!! (Request::query('status') == 'Undeployable' ? ' class="active"' : '') !!} ><a href="{{ url('hardware?status=Undeployable') }}"><i class="fa fa-times text-red"></i>
                          {{ trans('general.all') }}
                          {{ trans('general.undeployable') }}
                          ({{ (isset($total_undeployable_sidebar)) ? $total_undeployable_sidebar : '' }})
                      </a>
                  </li>
                  <li{!! (Request::query('status') == 'Archived' ? ' class="active"' : '') !!}><a href="{{ url('hardware?status=Archived') }}"><i class="fa fa-times text-red"></i>
                          {{ trans('general.all') }}
                          {{ trans('admin/hardware/general.archived') }}
                          ({{ (isset($total_archived_sidebar)) ? $total_archived_sidebar : '' }})
                          </a>
                  </li>
                    <li{!! (Request::query('status') == 'Requestable' ? ' class="active"' : '') !!}><a href="{{ url('hardware?status=Requestable') }}"><i class="fa fa-check text-blue"></i>
                        {{ trans('admin/hardware/general.requestable') }}
                        </a>
                    </li>

                    @can('audit', \App\Models\Asset::class)
                        <li{!! (Request::is('hardware/audit/due') ? ' class="active"' : '') !!}>
                            <a href="{{ route('assets.audit.due') }}">
                                <i class="fa fa-clock-o text-yellow"></i> {{ trans('general.audit_due') }}
                            </a>
                        </li>
                        <li{!! (Request::is('hardware/audit/overdue') ? ' class="active"' : '') !!}>
                            <a href="{{ route('assets.audit.overdue') }}">
                                <i class="fa fa-warning text-red"></i> {{ trans('general.audit_overdue') }}
                            </a>
                        </li>
                    @endcan

                  <li class="divider">&nbsp;</li>
                    @can('checkout', \App\Models\Asset::class)
                    <li{!! (Request::is('hardware/bulkcheckout') ? ' class="active"' : '') !!}>
                        <a href="{{ route('hardware/bulkcheckout') }}">
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
                    <i class="fa fa-floppy-o"></i>
                    <span>{{ trans('general.licenses') }}</span>
                  </a>
              </li>
              @endcan
              @can('index', \App\Models\Accessory::class)
              <li{!! (Request::is('accessories*') ? ' class="active"' : '') !!}>
                <a href="{{ route('accessories.index') }}">
                  <i class="fa fa-keyboard-o"></i>
                  <span>{{ trans('general.accessories') }}</span>
                </a>
              </li>
              @endcan
              @can('view', \App\Models\Consumable::class)
            <li{!! (Request::is('consumables*') ? ' class="active"' : '') !!}>
                <a href="{{ url('consumables') }}">
                  <i class="fa fa-tint"></i>
                  <span>{{ trans('general.consumables') }}</span>
                </a>
            </li>
             @endcan
             @can('view', \App\Models\Component::class)
            <li{!! (Request::is('components*') ? ' class="active"' : '') !!}>
                <a href="{{ route('components.index') }}">
                  <i class="fa fa-hdd-o"></i>
                  <span>{{ trans('general.components') }}</span>
                </a>
            </li>
            @endcan
            @can('view', \App\Models\PredefinedKit::class)
                <li{!! (Request::is('kits') ? ' class="active"' : '') !!}>
                    <a href="{{ route('kits.index') }}">
                        <i class="fa fa-object-group"></i>
                        <span>{{ trans('general.kits') }}</span>
                    </a>
                </li>
            @endcan

            @can('view', \App\Models\User::class)
            <li{!! (Request::is('users*') ? ' class="active"' : '') !!}>
                  <a href="{{ route('users.index') }}">
                      <i class="fa fa-users"></i>
                      <span>{{ trans('general.people') }}</span>
                  </a>
            </li>
            @endcan
            @can('import')
                <li{!! (Request::is('import/*') ? ' class="active"' : '') !!}>
                    <a href="{{ route('imports.index') }}">
                        <i class="fa fa-cloud-download"></i>
                        <span>{{ trans('general.import') }}</span>
                    </a>
                </li>
            @endcan

            @can('backend.interact')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gear" aria-hidden="true"></i>
                        <span>{{ trans('general.settings') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
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
                <a href="#"  class="dropdown-toggle">
                    <i class="fa fa-bar-chart"></i>
                    <span>{{ trans('general.reports') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('reports.activity') }}" {{ (Request::is('reports/activity') ? ' class="active"' : '') }}>
                            {{ trans('general.activity_report') }}
                        </a>
                    </li>

                    <li><a href="{{ route('reports.audit') }}" {{ (Request::is('reports.audit') ? ' class="active"' : '') }}>
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
                    <li>
                        <a href="{{ url('reports/custom') }}" {{ (Request::is('reports/custom') ? ' class="active"' : '') }}>
                            {{ trans('general.custom_report') }}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('viewRequestable', \App\Models\Asset::class)
            <li{!! (Request::is('account/requestable-assets') ? ' class="active"' : '') !!}>
            <a href="{{ route('requestable-assets') }}">
            <i class="fa fa-laptop"></i>
            <span>{{ trans('admin/hardware/general.requestable') }}</span>
            </a>
            </li>
            @endcan


          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <footer class="main-footer hidden-print">

<div class="pull-right hidden-xs">
    <!--
  @if ($snipeSettings->version_footer!='off')
      @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
        &nbsp; <strong>Version</strong> {{ config('version.app_version') }} - build {{ config('version.build_version') }} ({{ config('version.branch') }})
      @endif
  @endif

  @if ($snipeSettings->support_footer!='off')
      @if (($snipeSettings->support_footer=='on') || (($snipeSettings->support_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
        <a target="_blank" class="btn btn-default btn-xs" href="https://snipe-it.readme.io/docs/overview" rel="noopener">User's Manual</a>
        <a target="_blank" class="btn btn-default btn-xs" href="https://snipeitapp.com/support/" rel="noopener">Report a Bug</a>
         @endif
  @endif
                   -->
@if ($snipeSettings->privacy_policy_link!='')
    <a target="_blank" class="btn btn-default btn-xs" rel="noopener" href="{{  $snipeSettings->privacy_policy_link }}" target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
@endif


</div>
  @if ($snipeSettings->footer_text!='')
      <div class="pull-right">
          {!!  Parsedown::instance()->text(e($snipeSettings->footer_text))  !!}
      </div>
  @endif
  
                    
   UNCLASSIFIED</i>
</footer>

      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper" role="main">

          @if ($debug_in_production)
              <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                  <div class="col-md-12" style="margin-bottom: 0px; background-color: #b50408 ; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
                      <i class="fa fa-warning fa-3x pull-left"></i> <strong>{{ strtoupper(trans('general.debug_warning')) }}:</strong>
                      {!! trans('general.debug_warning_text') !!}
                  </div>
              </div>
      @endif

        <!-- Content Header (Page header) -->
        <section class="content-header" style="padding-bottom: 30px;">
          <h1 class="pull-left">
            @yield('title')


          </h1>

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

      <footer class="main-footer hidden-print">

        <div class="pull-right hidden-xs">
            <!--
          @if ($snipeSettings->version_footer!='off')
              @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                &nbsp; <strong>Version</strong> {{ config('version.app_version') }} - build {{ config('version.build_version') }} ({{ config('version.branch') }})
              @endif
          @endif

          @if ($snipeSettings->support_footer!='off')
              @if (($snipeSettings->support_footer=='on') || (($snipeSettings->support_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                <a target="_blank" class="btn btn-default btn-xs" href="https://snipe-it.readme.io/docs/overview" rel="noopener">User's Manual</a>
                <a target="_blank" class="btn btn-default btn-xs" href="https://snipeitapp.com/support/" rel="noopener">Report a Bug</a>
                 @endif
          @endif
                                   -->
        @if ($snipeSettings->privacy_policy_link!='')
            <a target="_blank" class="btn btn-default btn-xs" rel="noopener" href="{{  $snipeSettings->privacy_policy_link }}" target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
        @endif


        </div>
          @if ($snipeSettings->footer_text!='')
              <div class="pull-right">
                  {!!  Parsedown::instance()->text(e($snipeSettings->footer_text))  !!}
              </div>
          @endif
          

          UNCLASSIFIED</i>
      </footer>



    </div><!-- ./wrapper -->


    <!-- end main container -->

    <div class="modal modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                <form method="post" id="deleteForm" role="form">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('general.cancel') }}</button>
                    <button type="submit" class="btn btn-outline" id="dataConfirmOK">{{ trans('general.yes') }}</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Javascript files --}}
    <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>

    <!-- v5-beta: This pGenerator call must remain here for v5 - until fixed - so that the JS password generator works for the user create modal. -->
    <script src="{{ url('js/pGenerator.jquery.js') }}"></script>

    {{-- Page level javascript --}}
    @stack('js')

    @section('moar_scripts')
    @show


    <script nonce="{{ csrf_token() }}">


        // ignore: 'input[type=hidden]' is required here to validate the select2 lists
        $.validate({
            form : '#create-form',
            modules : 'date, toggleDisabled',
            disabledFormFilter : '#create-form',
            showErrorDialogs : true,
            ignore: 'input[type=hidden]'
        });





        $(function () {
  
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $('.select2 span').addClass('needsclick');
            $('.select2 span').removeAttr('title');

            // This javascript handles saving the state of the menu (expanded or not)
            $('body').bind('expanded.pushMenu', function() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('account.menuprefs', ['state'=>'open']) }}",
                    _token: "{{ csrf_token() }}"
                });

            });

            $('body').bind('collapsed.pushMenu', function() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('account.menuprefs', ['state'=>'close']) }}",
                    _token: "{{ csrf_token() }}"
                });
            });

        });

        // Initiate the ekko lightbox
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });



    </script>

    @if ((Session::get('topsearch')=='true') || (Request::is('/')))
    <script nonce="{{ csrf_token() }}">
         $("#tagSearch").focus();
    </script>
    @endif



  </body>
</html>
