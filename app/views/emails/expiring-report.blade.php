@extends('emails/layouts/default')

@section('content')

<p>There are {{{ $count }}} asset(s) with warrantees expiring in the next month.</p>


<table style="border: 1px solid black; padding: 5px;" width="100%">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Tag</strong></td>
		<td><strong>Expires</strong></td>
	</tr>
	
{{ $email_content }}
</table>


@stop
