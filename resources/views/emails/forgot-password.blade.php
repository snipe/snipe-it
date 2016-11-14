@extends('emails/layouts/default')

@section('content')
<<<<<<< HEAD
<p>Hello {{ $user->first_name }},</p>

<p>Please click on the following link to update your {{ \App\Models\Setting::getSettings()->site_name }} password:</p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>Best regards,</p>
=======
<p>{{ trans('mail.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('mail.link_to_update_password', ['web' => \App\Models\Setting::getSettings()->site_name]) }} </p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>{{ trans('mail.best_regards') }}</p>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
