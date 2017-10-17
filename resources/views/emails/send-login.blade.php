@extends('emails/layouts/default')

@section('content')
<p>{{ trans('mail.hello') }} {{ $first_name }},</p>

<p>{{ trans('mail.admin_has_created', ['web' => $snipeSettings->site_name]) }} </p>

<p>URL: <a href="{{ url('/') }}">{{ url('/') }}</a><br>
{{ trans('mail.login') }} {{ $username }} <br>
{{ trans('mail.password') }} {{ $password }}
</p>

<p>{{ trans('mail.best_regards') }}</p>

<p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
@stop
