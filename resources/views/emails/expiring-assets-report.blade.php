@extends('emails/layouts/default')

@section('content')

<p>There are {{ $count }} asset(s) with warrantees expiring in the next 60 days.</p>


<table style="border: 1px solid black; padding: 5px;" width="100%" cellspacing="0" cellpadding="3">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Tag</strong></td>
		<td><strong>Expires</strong></td>
		<td><strong>Days</strong></td>
        <td><strong>Supplier</strong></td>
        <td><strong>Assigned To</strong></td>
	</tr>

{!! $email_content !!}
</table>


@stop
