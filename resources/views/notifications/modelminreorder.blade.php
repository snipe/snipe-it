<!DOCTYPE html>
<html>
<head>
	<title>{{$title}}</title>
</head>
<body>
{{ trans('mail.hello') }},

{{ $title }}

{{ trans('mail.min_amt_message') }}

{{ trans('mail.best_regards') }} <br>
@if ($snipeSettings->show_url_in_emails=='1')
    <p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
@else
    <p>{{ $snipeSettings->site_name }}</p>
@endif
</body>
</html>
