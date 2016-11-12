@extends('emails/layouts/default')

@section('content')

<<<<<<< HEAD
<p>There are {{ $count }} items that are below minimum inventory or will soon be low.</p>


<table style="border: 1px solid black; padding: 5px;" width="100%" cellspacing="0" cellpadding="3">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Type</strong></td>
        <td><strong>Current QTY</strong></td>
        <td><strong>Min QTY</strong></td>
	</tr>

    @for($i=0; $count > $i; $i++)
    <tr>
        <td><a href="{{ config('app.url') }}/admin/{{ $data[$i]['type'] }}/{{ $data[$i]['id'] }}/view">{{ $data[$i]['name'] }}</a></td>
        <td>{{ $data[$i]['type'] }}</td>
        <td>{{ $data[$i]['remaining'] }}</td>
        <td>{{ $data[$i]['min_amt'] }}</td>
    </tr>

    @endfor


</table>
=======
    <p>{{ trans_choice('mail.There_are',$count) }} {{ $count }} {{ trans_choice('mail.items_below_minimum',$count) }}</p>

    <table style="border: 1px solid black; padding: 5px;" width="100%" cellspacing="0" cellpadding="3">
        <tr>
            <td><strong>{{ trans('mail.name') }}</strong></td>
            <td><strong>{{ trans('mail.type') }}</strong></td>
            <td><strong>{{ trans('mail.current_QTY') }}</strong></td>
            <td><strong>{{ trans('mail.min_QTY') }}</strong></td>
        </tr>

        @for($i=0; $count > $i; $i++)
            <tr>
                <td>
                    <a href="{{ config('app.url') }}/admin/{{ $data[$i]['type'] }}/{{ $data[$i]['id'] }}/view">{{ $data[$i]['name'] }}</a>
                </td>
                <td>{{ $data[$i]['type'] }}</td>
                <td>{{ $data[$i]['remaining'] }}</td>
                <td>{{ $data[$i]['min_amt'] }}</td>
            </tr>

        @endfor


    </table>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72


@stop
