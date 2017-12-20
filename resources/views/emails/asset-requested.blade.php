@extends('emails/layouts/default')

@section('content')

<p>{{ trans('mail.a_user_requested') }} <a href="{{ url('/') }}"> {{ $snipeSettings->site_name }}</a>. </p>

<p>{{ trans('mail.user') }} <a href="{{ route('users.show', $user_id) }}">{{ $requested_by }}</a><br>
   {{ trans('mail.item') }} <a href="{{ $item_url }}">{{ $item_name }}</a> ({{ $item_type }}) <br>
   {{ trans('general.requested') }} {{ $requested_date }}
@if ($item_quantity > 1)
        <br> {{ trans('general.qty') }} {{ $item_quantity}}
@endif

@if ($snipeSettings->show_url_in_emails=='1')
    <p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
@else
    <p>{{ $snipeSettings->site_name }}</p>
@endif

@stop
