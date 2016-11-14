@extends('emails/layouts/default')

@section('content')
<<<<<<< HEAD
<p>Hello {{ $first_name }},</p>

<p>An administrator has created an account for you on the {{ \App\Models\Setting::getSettings()->site_name }} website. </p>

<p>URL: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a><br>
Login: {{ $username }} <br>
Password: {{ $password }}
</p>

<p>Best regards,</p>
=======
<p>{{ trans('mail.hello') }} {{ $first_name }},</p>

<p>{{ trans('mail.admin_has_created', ['web' => \App\Models\Setting::getSettings()->site_name]) }} </p>

<p>URL: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a><br>
{{ trans('mail.login') }} {{ $username }} <br>
{{ trans('mail.password') }} {{ $password }}
</p>

<p>{{ trans('mail.best_regards') }}</p>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
