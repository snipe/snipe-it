@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('mail.welcome_to', ['web' => \App\Models\Setting::getSettings()->site_name]) }} {{ trans('mail.click_to_confirm', ['web' => \App\Models\Setting::getSettings()->site_name]) }}</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>{{ trans('mail.best_regards') }}</p>

<p>{{ \App\Models\Setting::getSettings()->site_name }}</p>
@stop
