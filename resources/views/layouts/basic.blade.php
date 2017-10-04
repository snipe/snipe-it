<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ($snipeSettings) && ($snipeSettings->site_name) ? $snipeSettings->site_name : 'Snipe-IT' }}</title>


    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url(asset('js/plugins/select2/select2.min.css')) }}">

    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">
    <link rel="shortcut icon" type="image/ico" href="{{ url(asset('favicon.ico')) }}">


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

        .btn-primary {
        background-color: {{ $snipeSettings->header_color }};
        border-color: {{ $snipeSettings->header_color }};
        }
        </style>

    @endif

</head>

<body class="hold-transition login-page">

    @if (($snipeSettings) && ($snipeSettings->logo!=''))
        <center>
            <img style="padding-top: 20px; padding-bottom: 10px; max-width: 150px" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
        </center>
    @endif
  <!-- Content -->
  @yield('content')



</body>

</html>
