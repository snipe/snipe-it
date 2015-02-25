@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $first_name }}},</p>

<p>A new asset has been checked out to you. Please read the terms of use below, and click on the link at the bottom to confirm that you read and agree to the terms of use, and have received the asset. </p>

<p>{{ $eula }}</p>

<p><strong><a href="{{{ Config::get('app.url') }}}/account/accept-asset/{{ $asset_id }}">I have read and agree to the terms of use, and have received this item.</a></strong></p>

<p>{{{ Setting::getSettings()->site_name }}}</p>
@stop
