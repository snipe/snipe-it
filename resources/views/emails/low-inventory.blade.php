@extends('emails/layouts/default')

@section('content')

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


@stop
