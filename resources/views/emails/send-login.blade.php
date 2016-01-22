@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $first_name }}},</p>

<p>An administrator has created an account for you on the {{{ Setting::getSettings()->site_name }}} website. </p>

<p>URL: <a href="{{ Config::get('app.url') }}">{{ Config::get('app.url') }}</a><br>
Login: {{{ $username }}} <br>
Password: {{{ $password }}}
</p>

<p>Best regards,</p>

<p>{{{ Setting::getSettings()->site_name }}}</p>
@stop
