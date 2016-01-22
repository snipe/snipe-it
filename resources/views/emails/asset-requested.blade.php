@extends('emails/layouts/default')

@section('content')

<p>A user has requested an asset on the <a href="{{ Config::get('app.url') }}">{{{ Setting::getSettings()->site_name }}} website</a>. </p>

<p>User: <a href="{{ Config::get('app.url') }}/admin/users/{{{ $user_id }}}/view">{{{ $requested_by }}}</a><br>
Asset: <a href="{{ Config::get('app.url') }}/hardware/{{{ $asset_id }}}/view">{{{ $asset_name }}}</a> ({{{ $asset_type }}}) <br>
Requested: {{{ $requested_date }}}
</p>

@stop
