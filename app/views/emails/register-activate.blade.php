@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $user->first_name }}},</p>

<p>Welcome to {{{ Setting::getSettings()->site_name }}}! Please click on the following link to confirm your {{{ Setting::getSettings()->site_name }}} account:</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>Best regards,</p>

<p>{{{ Setting::getSettings()->site_name }}}</p>
@stop
