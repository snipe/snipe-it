<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ Helper::determineLanguageDirection() }}" data-theme="light">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($snipeSettings) && ($snipeSettings->site_name) ? $snipeSettings->site_name : 'Snipe-IT' }}</title>

    <link rel="shortcut icon" type="image/ico" href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico' }}">

    @include('partials.theme-mode-preflight')

    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">

    @include('partials.theme-mode-tenant-vars')

    <script nonce="{{ csrf_token() }}">
        window.snipeit = {
            settings: {
                "per_page": 50
            }
        };
    </script>


    @if (($snipeSettings) && ($snipeSettings->header_color))
        <style>
        .main-header .navbar, .main-header .logo {
        background-color: {{ $snipeSettings->header_color }};
        background: -webkit-linear-gradient(top,  {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
        background: linear-gradient(to bottom, {{ $snipeSettings->header_color }} 0%,{{ $snipeSettings->header_color }} 100%);
        border-color: {{ $snipeSettings->header_color }};
        }
        .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a {
        border-left-color: {{ $snipeSettings->header_color }};
        }
        </style>
    @endif

    @if (($snipeSettings) && ($snipeSettings->custom_css))
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif

</head>

<body class="hold-transition login-page">

    @include('partials.impersonation-banner')

    {{-- Login / error page header bar. Styled with the tenant's
         var(--main-theme-color) background so the uploaded logo lives
         in the same colored context it does on the logged-in app's
         top-nav. Without this, tenants who designed a logo for a
         colored navbar (e.g. white text on brand color) would see it
         float against a plain light or dark body background where it
         may not read well. Falls back to site_name text when no logo
         is uploaded so the bar has something meaningful in it. --}}
    <header class="basic-page-header">
        {{-- Authenticated visitors (e.g. hit a 404 or 403 mid-session)
             get a clickable logo that bounces them back to the app
             home. Unauthenticated visitors (login page, forgot
             password, error-while-logged-out) have nowhere useful to
             go — the app URL just redirects back to login — so the
             logo renders as a non-interactive <span>. --}}
        @auth
            <a href="{{ config('app.url') }}" class="basic-page-header__link">
                @if (($snipeSettings) && ($snipeSettings->logo!=''))
                    <img id="login-logo" src="{{ Storage::disk('public')->url('').e($snipeSettings->logo) }}" alt="{{ $snipeSettings->site_name }}">
                @else
                    <span class="basic-page-header__site-name">{{ $snipeSettings->site_name ?? 'Snipe-IT' }}</span>
                @endif
            </a>
        @else
            <span class="basic-page-header__link">
                @if (($snipeSettings) && ($snipeSettings->logo!=''))
                    <img id="login-logo" src="{{ Storage::disk('public')->url('').e($snipeSettings->logo) }}" alt="{{ $snipeSettings->site_name }}">
                @else
                    <span class="basic-page-header__site-name">{{ $snipeSettings->site_name ?? 'Snipe-IT' }}</span>
                @endif
            </span>
        @endauth
        {{-- Light/dark toggle. Absolute-positioned on the right side of
             the header bar so the logo stays centered. Most login-page
             visitors will not use it; it's here so operators (and
             visual regression testing) can confirm both themes on
             pages that never authenticate. Wired up by the
             theme-mode-toggle partial included at the end of body. --}}
        <button
            type="button"
            data-theme-toggle
            aria-label="{{ trans('general.dark_mode') }}"
            class="basic-page-header__toggle"
            onclick="event.preventDefault();"
        ></button>
    </header>
  <!-- Content -->
  <main id="main">
    @yield('content')
  </main>

    <div class="text-center" style="padding-top: 100px;">
        @if (($snipeSettings) && ($snipeSettings->privacy_policy_link!=''))
        <a target="_blank" rel="noopener" href="{{  $snipeSettings->privacy_policy_link }}" target="_new">{{ trans('admin/settings/general.privacy_policy') }}</a>
    @endif
    </div>

    {{-- Javascript files --}}
    <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>

    @stack('js')

    @include('partials.theme-mode-toggle')
</body>

</html>
