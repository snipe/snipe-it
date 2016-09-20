@extends('emails/layouts/default')

@section('content')

<p>{{ trans('mail.a_user_requested', ['web' => \App\Models\Setting::getSettings()->site_name]) }} <a href="{{ config('app.url') }}"> </a> </p>

<p>{{ trans('mail.user') }} <a href="{{ config('app.url') }}/admin/users/{{ $user_id }}/view">{{ $requested_by }}</a><br>
{{ trans('mail.asset') }} <a href="{{ config('app.url') }}/hardware/{{ $asset_id }}/view">{{ $asset_name }}</a> ({{ $asset_type }}) <br>
{{ trans('mail.requested') }} {{ $requested_date }}
</p>

@stop
