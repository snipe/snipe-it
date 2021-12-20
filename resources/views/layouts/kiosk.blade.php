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

    @livewireStyles

  </head>

  @if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
      <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? Auth::user()->present()->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}" style="margin-left:0;">
  @else
      <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}" style="margin-left:0;">
  @endif

  <a class="skip-main" href="#main">Skip to main content</a>
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->


        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation" style="margin-left:0;">
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
                  @if(\Request::route()->getName()!='kiosk')
                      <li>
                          <a href="{{ route('kiosk') }}">
                              <i class="fas fa-clipboard"></i>
                              <span>Return to Kiosk Main Menu</span>
                          </a>
                      </li>
                  @endif

               <!-- User Account: style can be found in dropdown.less -->
               @if (Auth::check())
               <li class="dropdown user user-menu">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   @if (Auth::user()->present()->gravatar())
                       <img src="{{ Auth::user()->present()->gravatar() }}" class="user-image" alt="">
                   @else
                      <i class="fas fa-users" aria-hidden="true"></i>
                   @endif

                   <span class="hidden-xs">{{ Auth::user()->first_name }} <strong class="caret"></strong></span>
                 </a>
                 <ul class="dropdown-menu">
                   <!-- User image -->



                     <li>
                         <a href="{{ route('home') }}">
                             <i class="fas fa-tachometer-alt fa-fw" aria-hidden="true"></i> Return to Dashboard
                         </a>
                     </li>

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

            </ul>
          </div>
        </nav>
      </header>


      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper" role="main" style="margin-left:0;">

          @if ($debug_in_production)
              <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                  <div class="col-md-12" style="margin-bottom: 0px; background-color: #b50408 ; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
                      <i class="fas fa-exclamation-triangle fa-3x pull-left"></i> <strong>{{ strtoupper(trans('general.debug_warning')) }}:</strong>
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

      <footer class="main-footer hidden-print" style="margin-left:0;">

        <div class="pull-right hidden-xs">
          @if ($snipeSettings->version_footer!='off')
              @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                &nbsp; <strong>Version</strong> {{ config('version.app_version') }} - build {{ config('version.build_version') }} ({{ config('version.branch') }})
              @endif
          @endif

        @if ($snipeSettings->privacy_policy_link!='')
            <a target="_blank" class="btn btn-default btn-xs" rel="noopener" href="{{  $snipeSettings->privacy_policy_link }}" target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
        @endif


        </div>
          @if ($snipeSettings->footer_text!='')
              <div class="pull-right">
                  {!!  Parsedown::instance()->text(e($snipeSettings->footer_text))  !!}
              </div>
          @endif
          

          <a target="_blank" href="https://snipeitapp.com" rel="noopener">Snipe-IT</a> is open source software, made with <i class="fas fa-heart" style="color: #a94442; font-size: 10px" aria-hidden="true"></i><span class="sr-only">love</span> by <a href="https://twitter.com/snipeitapp" rel="noopener">@snipeitapp</a>.
      </footer>



    </div><!-- ./wrapper -->


    <!-- end main container -->

    <div class="modal modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('general.cancel') }}</button>
                    <button type="submit" class="btn btn-outline" id="dataConfirmOK">{{ trans('general.yes') }}</button>
                </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-warning fade" id="restoreConfirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
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



    @livewireScripts
  </body>
</html>
