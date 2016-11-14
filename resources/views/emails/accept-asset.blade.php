@extends('emails/layouts/default')

@section('content')
<<<<<<< HEAD
	<p>Hello {{ $first_name }},</p>


	<p>A new item has been checked out under your name, details are below.</p>
=======
	<p>{{ trans('mail.hello') }} {{ $first_name }},</p>


	<p>{{ trans('mail.new_item_checked') }}</p>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

	<table>
		<tr>
			<td>
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
		@if (isset($item_tag))
			<tr>
				<td>
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
		@if (isset($item_serial))
			<tr>
				<td>
<<<<<<< HEAD
					Serial:
=======
					{{ trans('mail.serial') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
				</td>
				<td>
					<strong>{{ $item_serial }}</strong>
				</td>
			</tr>
		@endif
		<tr>
			<td>
<<<<<<< HEAD
				Checkout Date:
=======
				{{ trans('mail.checkout_date') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
			</td>
			<td>
				<strong>{{ $checkout_date }}</strong>
			</td>
		</tr>
		@if (isset($expected_checkin))
			<tr>
				<td>
<<<<<<< HEAD
					Expected Checkin Date:
=======
					{{ trans('mail.expecting_checkin_date') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
				</td>
				<td>
					<strong>{{ $expected_checkin }}</strong>
				</td>
			</tr>
		@endif
		@if (isset($note))
			<tr>
				<td>
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
<<<<<<< HEAD

	@if (($require_acceptance==1) && ($eula!=''))

		Please read the terms of use below, and click on the link at the bottom to confirm that you read and agree to the terms of use, and have received the asset.

	@elseif (($require_acceptance==1) && ($eula==''))

		Please click on the link at the bottom to confirm that you have received the asset.

	@elseif (($require_acceptance==0) && ($eula!=''))

		Please read the terms of use below.

		@endif
=======
	<p>
	@if (($require_acceptance==1) && ($eula!=''))

		{{ trans('mail.read_the_terms_and_click') }}

	@elseif (($require_acceptance==1) && ($eula==''))

		{{ trans('mail.click_on_the_link_asset') }}

	@elseif (($require_acceptance==0) && ($eula!=''))

		{{ trans('mail.read_the_terms') }}

	@endif
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

		</p>

		<p><blockquote>{!! $eula !!}</blockquote></p>

		@if ($require_acceptance==1)
<<<<<<< HEAD
			<p><strong><a href="{{ config('app.url') }}/account/accept-asset/{{ $log_id }}">I have read and agree to the terms of use, and have received this item.</a></strong></p>
=======
			<p><strong><a href="{{ config('app.url') }}/account/accept-asset/{{ $log_id }}">{{ trans('mail.i_have_read') }}</a></strong></p>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
		@endif

		<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
