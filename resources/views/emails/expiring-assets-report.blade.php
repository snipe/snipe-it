@extends('emails/layouts/default')

@section('content')

<<<<<<< HEAD
<p>There are {{ $count }} asset(s) with warrantees expiring in the next 60 days.</p>


<table style="border: 1px solid black; padding: 5px;" width="100%" cellspacing="0" cellpadding="3">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Tag</strong></td>
		<td><strong>Expires</strong></td>
		<td><strong>Days</strong></td>
        <td><strong>Supplier</strong></td>
        <td><strong>Assigned To</strong></td>
=======
	<p>{{ trans_choice('mail.There_are',$count) }} {{ $count }} {{ trans_choice('mail.assets_warrantee_expiring',$count) }}</p>

<table style="border: 1px solid black; padding: 5px;" width="100%" cellspacing="0" cellpadding="3">
	<tr>
		<td><strong>{{ trans('mail.name') }}</strong></td>
		<td><strong>{{ trans('mail.tag') }}</strong></td>
		<td><strong>{{ trans('mail.expires') }}</strong></td>
		<td><strong>{{ trans('mail.Days') }}</strong></td>
        <td><strong>{{ trans('mail.supplier') }}</strong></td>
        <td><strong>{{ trans('mail.assigned_to') }}</strong></td>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
	</tr>

{!! $email_content !!}
</table>


@stop
