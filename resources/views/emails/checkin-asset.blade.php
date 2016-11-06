@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $first_name }},</p>


<p>{{ trans('mail.the_following_item') }}

<table>
	<tr>
		<td style="background-color:#ccc">
			{{ trans('mail.asset_name') }}
		</td>
		<td>
			<strong>{{ $item_name }}</strong>
		</td>
	</tr>
	@if ($item_tag)
		<tr>
			<td style="background-color:#ccc">
				{{ trans('mail.asset_tag') }}
			</td>
			<td>
				<strong>{{ $item_tag }}</strong>
			</td>
		</tr>
	@endif
	<tr>
		<td style="background-color:#ccc">
			{{ trans('mail.checkin_date') }}
		</td>
		<td>
			<strong>{{ $checkin_date }}</strong>
		</td>
	</tr>
	@if ($note)
		<tr>
			<td style="background-color:#ccc">
				{{ trans('mail.additional_notes') }}
			</td>
			<td>
				<strong>{{ $note }}</strong>
			</td>
		</tr>
	@endif
</table>

<p>{{ $snipeSettings->site_name }}</p>
@stop
