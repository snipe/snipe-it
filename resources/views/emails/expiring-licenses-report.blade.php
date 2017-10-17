@extends('emails/layouts/default')

@section('content')

	<p>{{ trans_choice('mail.There_are',$count) }} {{ $count }} {{ trans_choice('mail.licenses_expiring',$count) }}</p>

<table style="border: 1px solid black; padding: 5px;" width="100%" cellspacing="0" cellpadding="3">
	<tr>
		<td><strong>{{ trans('mail.name') }}</strong></td>
		<td><strong>{{ trans('mail.expires') }}</strong></td>
		<td><strong>{{ trans('mail.Days') }}</strong></td>
	</tr>

{!! $email_content !!}
</table>

@if ($snipeSettings->show_url_in_emails=='1')
	<p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
@else
	<p>{{ $snipeSettings->site_name }}</p>
@endif

@stop
