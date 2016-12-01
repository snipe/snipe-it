<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
      @section('title')
      @show

      :: {{ $snipeSettings->site_name }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datepicker/bootstrap-datepicker.css') }}">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/iCheck/all.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/skins/skin-blue.css') }}">

    <!-- bootstrap tables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-table.css') }}">

    <link rel="stylesheet" href="{{ asset(elixir('assets/css/app.css')) }}">

    <link rel="shortcut icon" type="image/ico" href="{{ asset('favicon.ico') }}">

    <style>
        @if ($snipeSettings)
            @if ($snipeSettings->header_color)
            .main-header .navbar, .main-header .logo {
            background-color: {{ $snipeSettings->header_color }};
            background: -webkit-linear-gradient(top,  {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
            background: linear-gradient(to bottom, {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
            border-color: {{ $snipeSettings->header_color }};
            }
            .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
              border-left-color: {{ $snipeSettings->header_color }};
            }

            .btn-primary {
              background-color: {{ $snipeSettings->header_color }};
              border-color: {{ $snipeSettings->header_color }};
            }

            @endif

        @if ($snipeSettings->custom_css)
            {{ $snipeSettings->show_custom_css() }}
        @endif
     @endif
    @media (max-width: 400px) {
      .navbar-left {
       margin: 2px;
      }

      .nav::after {
        clear: none;
      }
    }
    </style>

    <script>
          window.snipeit = {
              settings: {
                  "per_page": {{ $snipeSettings->per_page }}
              }
          };
      </script>

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>

      @if ($snipeSettings->load_remote=='1')

            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

       @else
            <script src="{{ asset('assets/js/html5shiv.js') }}"></script>
            <script src="{{ asset('assets/js/respond.js') }}"></script>
       @endif
       <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->


        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button above the compact sidenav -->
          <a href="#" style="color: white" class="sidebar-toggle btn btn-white" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <ul class="nav navbar-nav navbar-left">
              <li class="left-navblock">
                 @if ($snipeSettings->brand == '3')
                      <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                          <img class="navbar-brand-img" src="{{ config('app.url') }}/uploads/{{ $snipeSettings->logo }}">
                          {{ $snipeSettings->site_name }}
                      </a>
                  @elseif ($snipeSettings->brand == '2')
                      <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                          <img class="navbar-brand-img" src="{{ config('app.url') }}/uploads/{{ $snipeSettings->logo }}">
                      </a>
                  @else
                      <a class="logo no-hover" href="{{ config('app.url') }}">
                          {{ $snipeSettings->site_name }}
                      </a>
                  @endif
              </li>
            </ul> 

          <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                  @can('assets.view')
                  <li {!! (Request::is('hardware*') ? ' class="active"' : '') !!}>
                      <a href="{{ URL::to('hardware') }}">
                          <i class="fa fa-barcode"></i>
                      </a>
                  </li>
                  @endcan
                  @can('licenses.view')
                  <li {!! (Request::is('admin/licenses*') ? ' class="active"' : '') !!}>
                      <a href="{{ URL::to('admin/licenses') }}">
                          <i class="fa fa-floppy-o"></i>
                      </a>
                  </li>
                  @endcan
                  @can('accessories.view')
                  <li {!! (Request::is('admin/accessories*') ? ' class="active"' : '') !!}>
                      <a href="{{ URL::to('admin/accessories') }}">
                          <i class="fa fa-keyboard-o"></i>
                      </a>
                  </li>
                  @endcan
                  @can('consumables.view')
                  <li {!! (Request::is('admin/consumables*') ? ' class="active"' : '') !!}>
                      <a href="{{ URL::to('admin/consumables') }}">
                          <i class="fa fa-tint"></i>
                      </a>
                  </li>
                  @endcan
                  @can('components.view')
                  <li {!! (Request::is('admin/components*') ? ' class="active"' : '') !!}>
                      <a href="{{ URL::to('admin/components') }}">
                          <i class="fa fa-hdd-o"></i>
                      </a>
                  </li>
                  @endcan

                  @can('assets.view')
                  <form class="navbar-form navbar-left form-horizontal" role="search" action="{{ route('findbytag/hardware') }}" method="get">
                      <div class="col-xs-12 col-md-12">
                          <div class="col-xs-12 form-group">
                              <label class="sr-only" for="tagSearch">{{ trans('general.lookup_by_tag') }}</label>
                              <input type="text" class="form-control" id="tagSearch" name="assetTag" placeholder="{{ trans('general.lookup_by_tag') }}">
                              <input type="hidden" name="topsearch" value="true">
                          </div>
                          <div class="col-xs-1">
                              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i></button>
                          </div>
                      </div>
                  </form>
                  @endcan

                  @can('admin')
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      @lang('general.create')
                      <b class="caret"></b>
                    </a>
                   <ul class="dropdown-menu">
                     @can('assets.create')
                      <li {!! (Request::is('hardware/create') ? 'class="active>"' : '') !!}>
                              <a href="{{ route('create/hardware') }}">
                                  <i class="fa fa-barcode fa-fw"></i>
                                  @lang('general.asset')</a>
                      </li>
                       @endcan
                       @can('licenses.create')
                       <li {!! (Request::is('admin/licenses/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('create/licenses') }}">
                               <i class="fa fa-floppy-o fa-fw"></i>
                               @lang('general.license')</a>
                       </li>
                       @endcan
                       @can('accessories.create')
                       <li {!! (Request::is('admin/accessories/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('create/accessory') }}">
                               <i class="fa fa-keyboard-o fa-fw"></i>
                               @lang('general.accessory')</a>
                       </li>
                       @endcan
                       @can('consumables.create')
                       <li {!! (Request::is('admin/consumables/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('create/consumable') }}">
                               <i class="fa fa-tint fa-fw"></i>
                               @lang('general.consumable')</a>
                       </li>
                       @endcan
                       @can('users.create')
                       <li {!! (Request::is('admin/users/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('create/user') }}">
                           <i class="fa fa-user fa-fw"></i>
                           @lang('general.user')</a>
                       </li>
                       @endcan
                       @can('components.create')
                       <li {!! (Request::is('admin/components/create') ? 'class="active"' : '') !!}>
                           <a href="{{ route('create/component') }}">
                           <i class="fa fa-hdd-o"></i>
                           @lang('general.component')</a>
                       </li>
                       @endcan
                   </ul>
                </li>
               @endcan

               @can('admin')
               <!-- Tasks: style can be found in dropdown.less -->
               <?php $alert_items = \App\Helpers\Helper::checkLowInventory(); ?>

               <li class="dropdown tasks-menu">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="fa fa-flag-o"></i>
                   @if (count($alert_items))
                    <span class="label label-danger">{{ count($alert_items) }}</span>
                   @endif
                 </a>
                 <ul class="dropdown-menu">
                   <li class="header">You have {{ count($alert_items) }} items below or almost below minimum quantity levels</li>
                   <li>
                     <!-- inner menu: contains the actual data -->
                     <ul class="menu">

                      @for($i=0; count($alert_items) > $i; $i++)

                        <li><!-- Task item -->
                          <a href="{{ config('app.url') }}/admin/{{ $alert_items[$i]['type'] }}/{{ $alert_items[$i]['id'] }}/view">
                            <h3>{{ $alert_items[$i]['name'] }}
                              <small class="pull-right">
                                {{ $alert_items[$i]['remaining'] }} remaining
                              </small>
                            </h3>
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


               <!-- User Account: style can be found in dropdown.less -->
               <li class="dropdown user user-menu">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   @if (Auth::user()->gravatar())
                       <img src="{{ Auth::user()->gravatar() }}" class="user-image" alt="User Image">
                   @else
                      <i class="fa fa-user fa-fws"></i>
                   @endif

                   <span class="hidden-xs">{{ Auth::user()->first_name }} <b class="caret"></b></span>
                 </a>
                 <ul class="dropdown-menu">
                   <!-- User image -->
                     <li {!! (Request::is('account/profile') ? ' class="active"' : '') !!}>
                       <a href="{{ route('view-assets') }}">
                             <i class="fa fa-check fa-fw"></i> @lang('general.viewassets')
                       </a>
                          <a href="{{ route('profile') }}">
                             <i class="fa fa-user fa-fw"></i> @lang('general.editprofile')
                         </a>
                     </li>
                     <li class="divider"></li>
                     <li>
                         <a href="{{ url('/logout') }}">
                             <i class="fa fa-sign-out fa-fw"></i>
                             @lang('general.logout')
                         </a>
                     </li>
                 </ul>
               </li>


               @can('superadmin')
               <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                       <i class="fa fa-wrench fa-fw"></i> @lang('general.admin')
                       <b class="caret"></b>
                   </a>
                   <ul class="dropdown-menu">
                       <li {!! (Request::is('admin/settings/companies*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/companies') }}">
                               <i class="fa fa-building-o fa-fw"></i> @lang('general.companies')
                           </a>
                       </li>
                       <li {!! (Request::is('hardware/models*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('hardware/models') }}">
                               <i class="fa fa-th fa-fw"></i> @lang('general.asset_models')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/settings/categories*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/categories') }}">
                               <i class="fa fa-check fa-fw"></i> @lang('general.categories')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/settings/manufacturers*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/manufacturers') }}">
                               <i class="fa fa-briefcase fa-fw"></i> @lang('general.manufacturers')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/settings/suppliers*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/suppliers') }}">
                               <i class="fa fa-credit-card fa-fw"></i> @lang('general.suppliers')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/settings/statuslabels*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/statuslabels') }}">
                               <i class="fa fa-list fa-fw"></i> @lang('general.status_labels')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/settings/depreciations*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/depreciations') }}">
                               <i class="fa fa-arrow-down fa-fw"></i> @lang('general.depreciation')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/settings/locations*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/locations') }}">
                               <i class="fa fa-globe fa-fw"></i> @lang('general.locations')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/groups*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/groups') }}">
                               <i class="fa fa-group fa-fw"></i> @lang('general.groups')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/settings/backups*') ? ' class="active"' : '') !!}>
                           <a href="{{ URL::to('admin/settings/backups') }}">
                               <i class="fa fa-download fa-fw"></i> @lang('admin/settings/general.backups')
                           </a>
                       </li>
                       <li {!! (Request::is('admin/custom_fields*') ? ' class="active"' : '') !!}>
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
               @endcan
            </ul>
          </div>
      </nav>
       <a href="#" style="float:left" class="sidebar-toggle-mobile visible-xs btn" data-toggle="offcanvas" role="button">
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
          <ul class="sidebar-menu">
            @can('admin')
            <li {!! (\Request::route()->getName()=='home' ? ' class="active"' : '') !!}>
              <a href="{{ route('home') }}">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            @endcan
            @can('assets.view')
            <li class="treeview{{ (Request::is('hardware*') ? ' active' : '') }}">
                <a href="#"><i class="fa fa-barcode"></i>
                  <span>{{ trans('general.assets') }}</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{ URL::to('hardware') }}">@lang('general.list_all')</a>
                  </li>

                    <?php $status_navs = \App\Models\Statuslabel::where('show_in_nav','=',1)->get(); ?>
                    @if (count($status_navs) > 0)
                        <li class="divider">&nbsp;</li>
                        @foreach ($status_navs as $status_nav)
                            <li><a href="{{ URL::to('hardware?status_id='.$status_nav->id) }}"}> {{ $status_nav->name }}</a></li>
                        @endforeach
                    @endif


                  <li{!! (Request::query('status') == 'Deployed' ? ' class="active"' : '') !!}>
                    <a href="{{ URL::to('hardware?status=Deployed') }}">@lang('general.deployed')
                    </a>
                  </li>
                  <li{!! (Request::query('status') == 'RTD' ? ' class="active"' : '') !!}>
                    <a href="{{ URL::to('hardware?status=RTD') }}">
                    @lang('general.ready_to_deploy')</a>
                  </li>
                  <li{!! (Request::query('status') == 'Pending' ? ' class="active"' : '') !!}><a href="{{ URL::to('hardware?status=Pending') }}">@lang('general.pending')</a></li>
                  <li{!! (Request::query('status') == 'Undeployable' ? ' class="active"' : '') !!} ><a href="{{ URL::to('hardware?status=Undeployable') }}">@lang('general.undeployable')</a></li>
                  <li{!! (Request::query('status') == 'Archived' ? ' class="active"' : '') !!}><a href="{{ URL::to('hardware?status=Archived') }}">@lang('admin/hardware/general.archived')</a></li>
                    <li{!! (Request::query('status') == 'Requestable' ? ' class="active"' : '') !!}><a href="{{ URL::to('hardware?status=Requestable') }}">@lang('admin/hardware/general.requestable')</a></li>

                  <li class="divider">&nbsp;</li>
                    @can('assets.checkout')
                    <li{!! (Request::is('hardware/bulkcheckout') ? ' class="active>"' : '') !!}>
                        <a href="{{ route('hardware/bulkcheckout') }}">
                            {{ trans('general.bulk_checkout') }}</a>
                    </li>
                    @endcan

                    @can('superuser')
                    <li{!! (Request::is('hardware/models*') ? ' class="active"' : '') !!}><a href="{{ URL::to('hardware/models') }}">@lang('general.asset_models')</a></li>
                  <li><a href="{{ URL::to('admin/settings/categories') }}" {!! (Request::is('admin/settings/categories*') ? ' class="active"' : '') !!} >@lang('general.categories')</a></li>
                    @endcan
                    @can('assets.create')
                      <li{!! (Request::query('Deleted') ? ' class="active"' : '') !!}><a href="{{ URL::to('hardware?status=Deleted') }}">@lang('general.deleted')</a></li>
                      <li><a href="{{ URL::to('admin/asset_maintenances') }}"  >@lang('general.asset_maintenances') </a></li>
                      <li><a href="{{ URL::to('hardware/import') }}">@lang('general.import') </a></li>
                      <li><a href="{{ URL::to('hardware/history') }}">@lang('general.import-history') </a></li>
                    @endcan
                </ul>
              </li>
              @endcan
              @can('licenses.view')
              <li{!! (Request::is('admin/licenses*') ? ' class="active"' : '') !!}>
                  <a href="{{ URL::to('admin/licenses') }}">
                    <i class="fa fa-floppy-o"></i>
                    <span>@lang('general.licenses')</span>
                  </a>
              </li>
              @endcan
              @can('accessories.view')
              <li{!! (Request::is('admin/accessories*') ? ' class="active"' : '') !!}>
                <a href="{{ URL::to('admin/accessories') }}">
                  <i class="fa fa-keyboard-o"></i>
                  <span>@lang('general.accessories')</span>
                </a>
              </li>
              @endcan
              @can('consumables.view')
            <li{!! (Request::is('admin/consumables*') ? ' class="active"' : '') !!}>
                <a href="{{ URL::to('admin/consumables') }}">
                  <i class="fa fa-tint"></i>
                  <span>@lang('general.consumables')</span>
                </a>
            </li>
             @endcan
             @can('components.view')
            <li{!! (Request::is('admin/components*') ? ' class="active"' : '') !!}>
                <a href="{{ URL::to('admin/components') }}">
                  <i class="fa fa-hdd-o"></i>
                  <span>@lang('general.components')</span>
                </a>
            </li>
            @endcan
            @can('users.view')
            <li{!! (Request::is('admin/users*') ? ' class="active"' : '') !!}>
                  <a href="{{ URL::to('admin/users') }}">
                      <i class="fa fa-users"></i>
                      <span>@lang('general.people')</span>
                  </a>
            </li>
            @endcan
            @can('reports.view')
            <li class="treeview{{ (Request::is('reports*') ? ' active' : '') }}">
                <a href="{{ URL::to('reports') }}"  class="dropdown-toggle">
                    <i class="fa fa-bar-chart"></i>
                    <span>@lang('general.reports')</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
	                 <li><a href="{{ URL::to('reports/activity') }}" {{ (Request::is('reports/activity') ? ' class="active"' : '') }} >@lang('general.activity_report')</a></li>

                    <li><a href="{{ URL::to('reports/depreciation') }}" {{ (Request::is('reports/depreciation') ? ' class="active"' : '') }} >@lang('general.depreciation_report')</a></li>
                    <li><a href="{{ URL::to('reports/licenses') }}" {{ (Request::is('reports/licenses') ? ' class="active"' : '') }} >@lang('general.license_report')</a></li>
                    <li><a href="{{ URL::to('reports/asset_maintenances') }}" {{ (Request::is('reports/asset_maintenances') ? ' class="active"' : '') }} >@lang('general.asset_maintenance_report')</a></li>
                    <li><a href="{{ URL::to('reports/assets') }}" {{ (Request::is('reports/assets') ? ' class="active"' : '') }} >@lang('general.asset_report')</a></li>
                    <li><a href="{{ URL::to('reports/unaccepted_assets') }}" {{ (Request::is('reports/unaccepted_assets') ? ' class="active"' : '') }} >@lang('general.unaccepted_asset_report')</a></li>
                    <li><a href="{{ URL::to('reports/accessories') }}" {{ (Request::is('reports/accessories') ? ' class="active"' : '') }} >@lang('general.accessory_report')</a></li>
                    <li><a href="{{ URL::to('reports/custom') }}" {{ (Request::is('reports/custom') ? ' class="active"' : '') }}>@lang('general.custom_report')</a></li>
                </ul>
            </li>
            @endcan
            @can('assets.view.requestable')
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

      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">

          @if ($debug_in_production)
              <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                  <div class="col-md-12" style="margin-bottom: 0px; background-color: red; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
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
          <div class="pull-right">
            @yield('header_right')
          </div>



        </section>


        <section class="content">
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
          @yield('content')

        </section>

      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> {{ config('version.app_version') }}  build {{ config('version.build_version') }} ({{ config('version.hash_version') }})
          <a target="_blank" class="btn btn-default btn-xs" href="https://snipe-it.readme.io">Documentation</a>
          <a target="_blank" class="btn btn-default btn-xs" href="https://snipe-it-manual.readme.io">User's Manual</a>
          <a target="_blank" class="btn btn-default btn-xs" href="https://snipeitapp.com/support/">Report a Bug</a>
        </div>
        <a target="_blank" href="https://snipeitapp.com">Snipe-IT</a> is an open source
        project, made with <i class="fa fa-heart" style="color: #a94442; font-size: 10px"></i> by <a href="https://twitter.com/snipeyhead">@snipeyhead</a>.
      </footer>



    </div><!-- ./wrapper -->


    <!-- end main container -->

    <div class="modal  modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default  pull-left" data-dismiss="modal">Close</button>
                    <a class="btn btn-outline" id="dataConfirmOK">@lang('general.yes')</a>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset(elixir('assets/js/all.js')) }}"></script>

    <script>
       $(function () {
         //Initialize Select2 Elements
         var iOS = /iPhone|iPad|iPod/.test(navigator.userAgent)  && !window.MSStream;
         if(!iOS)
         {
          $(".select2").select2();
         }
         $('.datepicker').datepicker();
       });

       //Flat blue color scheme for iCheck
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
     </script>

     <script type="text/javascript">
     $(document).ready(function () {

         $('.slideout-menu-toggle').on('click', function(event){
           console.log('clicked');
         	event.preventDefault();
         	// create menu variables
         	var slideoutMenu = $('.slideout-menu');
         	var slideoutMenuWidth = $('.slideout-menu').width();

         	// toggle open class
         	slideoutMenu.toggleClass("open");

         	// slide menu
         	if (slideoutMenu.hasClass("open")) {
             slideoutMenu.show();
     	    	slideoutMenu.animate({
     		    	right: "0px"
     	    	});
         	} else {
     	    	slideoutMenu.animate({
     		    	right: -slideoutMenuWidth
     	    	}, "-350px");
             slideoutMenu.fadeOut();
         	}
         });
     });
     </script>


    @section('moar_scripts')
    @show
    @if ((Session::get('topsearch')=='true') || (Request::is('/')))
    <script>
         $("#tagSearch").focus();
    </script>
        @endif

  </body>
</html>
