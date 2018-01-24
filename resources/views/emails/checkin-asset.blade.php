@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $first_name }} {{ $last_name }},</p>


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
	@if (isset($manufacturer_name))
		<tr>
			<td style="background-color:#ccc">
				{{ trans('general.manufacturer') }}
			</td>
			<td>
				<strong>{{ $manufacturer_name }}</strong>
			</td>
		</tr>
	@endif
	@if (isset($model_number))
		<tr>
			<td style="background-color:#ccc">
				{{ trans('general.model_no') }}:
			</td>
			<td>
				<strong>{{ $model_number }}</strong>
			</td>
		</tr>
	@endif
	@if (isset($model_name))
		<tr>
			<td style="background-color:#ccc">
				{{ trans('general.asset_model') }}:
			</td>
			<td>
				<strong>{{ $model_name }}</strong>
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

@if ($snipeSettings->show_url_in_emails=='1')
	<p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
@else
	<p>{{ $snipeSettings->site_name }}</p>
@endif

@stop
