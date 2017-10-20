@if ($show_url_in_emails=='1')
[{{ $slot }}]({{ $url }})
@else
{{ $slot }}
@endif

