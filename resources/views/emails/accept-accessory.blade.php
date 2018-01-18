@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $first_name }},</p>


<p>{{ trans('mail.new_item_checked') }}</p>

<table>
	<tr>
		<td>
			{{ trans('mail.accessory_name') }}
		</td>
		<td>
			<strong>{{ $item_name }}</strong>
		</td>
	</tr>
	<tr>
		<td>
			{{ trans('mail.checkout_date') }}
		</td>
		<td>
			<strong>{{ $checkout_date }}</strong>
		</td>
	</tr>
	@if ($note)
		<tr>
			<td>
				{{ trans('mail.additional_notes') }}
			</td>
			<td>
				<strong>{{ $note }}</strong>
			</td>
		</tr>
	@endif
</table>
<p>
@if (($require_acceptance==1) && ($eula!=''))

	{{ trans('mail.read_the_terms_and_click') }}

@elseif (($require_acceptance==1) && ($eula==''))

	{{ trans('mail.click_on_the_link_accessory') }}

@elseif (($require_acceptance==0) && ($eula!=''))

	{{ trans('mail.read_the_terms') }}

@endif

</p>

<p><blockquote>{!! $eula !!}</blockquote></p>

@if ($require_acceptance==1)
<p><strong><a href="{{ url('/') }}/account/accept-asset/{{ $log_id }}">{{ trans('mail.i_have_read') }}</a></strong></p>
@endif

@if ($snipeSettings->show_url_in_emails=='1')
	<p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
@else
	<p>{{ $snipeSettings->site_name }}</p>
@endif

@stop
