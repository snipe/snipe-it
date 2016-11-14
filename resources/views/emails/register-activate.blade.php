@extends('emails/layouts/default')

@section('content')
<<<<<<< HEAD
<p>Hello {{ $user->first_name }},</p>

<p>Welcome to {{ \App\Models\Setting::getSettings()->site_name }}! Please click on the following link to confirm your {{ \App\Models\Setting::getSettings()->site_name }} account:</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>Best regards,</p>
=======
<p>{{ trans('mail.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('mail.welcome_to', ['web' => \App\Models\Setting::getSettings()->site_name]) }} {{ trans('mail.click_to_confirm', ['web' => \App\Models\Setting::getSettings()->site_name]) }}</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>{{ trans('mail.best_regards') }}</p>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
