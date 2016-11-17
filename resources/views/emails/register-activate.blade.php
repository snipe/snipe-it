@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('mail.welcome_to', ['web' => $snipeSettings->site_name]) }} {{ trans('mail.click_to_confirm', ['web' => $snipeSettings->site_name]) }}</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>{{ trans('mail.best_regards') }}</p>

<p>{{ $snipeSettings->site_name }}</p>
@stop
