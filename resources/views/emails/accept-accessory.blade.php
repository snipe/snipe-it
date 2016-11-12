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
			Accessory Name:
=======
			{{ trans('mail.accessory_name') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
		</td>
		<td>
			<strong>{{ $item_name }}</strong>
		</td>
	</tr>
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
	@if ($note)
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

	Please click on the link at the bottom to confirm that you have received the accessory.

@elseif (($require_acceptance==0) && ($eula!=''))

	Please read the terms of use below.
=======
<p>
@if (($require_acceptance==1) && ($eula!=''))

	{{ trans('mail.read_the_terms_and_click') }}

@elseif (($require_acceptance==1) && ($eula==''))

	{{ trans('mail.click_on_the_link_accessory') }}

@elseif (($require_acceptance==0) && ($eula!=''))

	{{ trans('mail.read_the_terms') }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

@endif

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
