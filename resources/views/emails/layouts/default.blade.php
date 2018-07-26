<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
    body, p {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
    }

    td {
        background-color:#d2d6de;
        font-size: 13px;
    }

    p {
        padding-top: 10px;
    }
    </style>
</head>
<body>
    @yield('content')

@if ($snipeSettings->privacy_policy_link!='')
<a href="{{ $snipeSettings->privacy_policy_link }}">{{ trans('admin/settings/general.privacy_policy') }}</a>
@endif
</body>
</html>
