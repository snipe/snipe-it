@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $first_name }}},</p>


<p>A new item has been checked out under your name, details are below.

<table>
	<tr>
		<td style="background-color:#ccc">
			Asset Name:
		</td>
		<td>
			<strong>{{{ $item_name }}}</strong>
		</td>
	</tr>
	@if ($item_tag)
		<tr>
			<td style="background-color:#ccc">
				Asset Tag:
			</td>
			<td>
				<strong>{{{ $item_tag }}}</strong>
			</td>
		</tr>
	@endif
  @if ($item_serial)
		<tr>
			<td style="background-color:#ccc">
				Serial:
			</td>
			<td>
				<strong>{{{ $item_serial }}}</strong>
			</td>
		</tr>
	@endif
	<tr>
		<td style="background-color:#ccc">
			Checkout Date:
		</td>
		<td>
			<strong>{{{ $checkout_date }}}</strong>
		</td>
	</tr>
	@if ($expected_checkin)
		<tr>
			<td style="background-color:#ccc">
				Expected Checkin Date:
			</td>
			<td>
				<strong>{{{ $expected_checkin }}}</strong>
			</td>
		</tr>
	@endif
	@if ($note)
		<tr>
			<td style="background-color:#ccc">
				Additional Notes:
			</td>
			<td>
				<strong>{{{ $note }}}</strong>
			</td>
		</tr>
	@endif
</table>

@if (($require_acceptance==1) && ($eula!=''))

	Please read the terms of use below, and click on the link at the bottom to confirm that you read and agree to the terms of use, and have received the asset.

@elseif (($require_acceptance==1) && ($eula==''))

	Please click on the link at the bottom to confirm that you have received the asset.

@elseif (($require_acceptance==0) && ($eula!=''))

	Please read the terms of use below.

@endif

</p>

<p><blockquote>{{ $eula }}</blockquote></p>

@if ($require_acceptance==1)
<p><strong><a href="{{{ Config::get('app.url') }}}/account/accept-asset/{{ $log_id }}">I have read and agree to the terms of use, and have received this item.</a></strong></p>
@endif

<p>{{{ Setting::getSettings()->site_name }}}</p>
@stop
