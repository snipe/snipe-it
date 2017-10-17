@extends('emails/layouts/default')

@section('content')

<p>{{ trans('mail.a_user_canceled') }} <a href="{{ url('/') }}"> {{ $snipeSettings->site_name }}</a>. </p>

<p>{{ trans('mail.user') }} <a href="{{ route('users.show', $user_id) }}">{{ $requested_by }}</a><br>
   {{ trans('mail.item') }} <a href="{{ $item_url }}">{{ $item_name }}</a> ({{ $item_type }}) <br>
   {{ trans('mail.canceled') }} {{ $requested_date }}
</p>

@if ($snipeSettings->show_url_in_emails=='1')
   <p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
@else
   <p>{{ $snipeSettings->site_name }}</p>
@endif
@stop
