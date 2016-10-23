@extends('emails/layouts/default')

@section('content')
<p>Hello {{ $user->first_name }},</p>

<p>Welcome to {{ \App\Models\Setting::getSettings()->site_name }}! Please click on the following link to confirm your {{ \App\Models\Setting::getSettings()->site_name }} account:</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>Best regards,</p>

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
