@extends('emails/layouts/default')

@section('content')

<p>{{ trans('mail.a_user_canceled') }} <a href="{{ config('app.url') }}"> {{ $snipeSettings->site_name }}</a>. </p>

<p>{{ trans('mail.user') }} <a href="{{ config('app.url') }}/admin/users/{{ $user_id }}/view">{{ $requested_by }}</a><br>
   {{ trans('mail.item') }} <a href="{{ $item_url }}">{{ $item_name }}</a> ({{ $item_type }}) <br>
   {{ trans('mail.canceled') }} {{ $requested_date }}
</p>

@stop
