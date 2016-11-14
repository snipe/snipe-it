@extends('emails/layouts/default')

@section('content')
<<<<<<< HEAD
<p>Hello {{ $first_name }},</p>


<p>The following item has been checked in: 
=======
<p>{{ trans('mail.hello') }} {{ $first_name }},</p>


<p>{{ trans('mail.the_following_item') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

<table>
	<tr>
		<td style="background-color:#ccc">
<<<<<<< HEAD
			Asset Name:
=======
			{{ trans('mail.asset_name') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
		</td>
		<td>
			<strong>{{ $item_name }}</strong>
		</td>
	</tr>
	@if ($item_tag)
		<tr>
			<td style="background-color:#ccc">
<<<<<<< HEAD
				Asset Tag:
=======
				{{ trans('mail.asset_tag') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
			</td>
			<td>
				<strong>{{ $item_tag }}</strong>
			</td>
		</tr>
	@endif
	<tr>
		<td style="background-color:#ccc">
<<<<<<< HEAD
			Checkin Date:
=======
			{{ trans('mail.checkin_date') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
		</td>
		<td>
			<strong>{{ $checkin_date }}</strong>
		</td>
	</tr>
	@if ($note)
		<tr>
			<td style="background-color:#ccc">
<<<<<<< HEAD
				Additional Notes:
=======
				{{ trans('mail.additional_notes') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
			</td>
			<td>
				<strong>{{ $note }}</strong>
			</td>
		</tr>
	@endif
</table>

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
