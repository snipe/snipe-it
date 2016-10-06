@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('mail.link_to_update_password', ['web' => \App\Models\Setting::getSettings()->site_name]) }} </p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>{{ trans('mail.best_regards') }}</p>

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
