@extends('emails/layouts/default')

@section('content')
<p>Hello {{ $user->first_name }},</p>

<p>Please click on the following link to update your {{ \App\Models\Setting::getSettings()->site_name }} password:</p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>Best regards,</p>

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
