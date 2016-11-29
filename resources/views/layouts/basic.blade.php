<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Snipe-IT</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datepicker/bootstrap-datepicker.css') }}">

    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skins/skin-blue.css') }}">

    <!-- bootstrap tables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-table.css') }}">

    <link rel="stylesheet" href="{{ elixir('assets/css/app.css') }}">
    <link rel="shortcut icon" type="image/ico" href="{{ asset('favicon.ico') }}">


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
    <center><img class="logo" style="padding-top: 20px; padding-bottom: 10px;" src="{{ config('app.url') }}/uploads/{{ $snipeSettings->logo }}"></center>
    @endif
  <!-- Content -->
  @yield('content')



</body>

</html>
